#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
简单的 PO 到 MO 编译器
用于将 .po 文件编译为 WordPress 可用的 .mo 文件
"""

import struct
import os
import glob

def parse_po_file(po_file):
    """解析 PO 文件并返回翻译字典"""
    entries = {}
    current_msgid = ''
    current_msgstr = ''
    in_msgid = False
    in_msgstr = False
    
    with open(po_file, 'r', encoding='utf-8') as f:
        for line in f:
            line = line.strip()
            
            # 跳过注释和空行
            if not line or line.startswith('#'):
                continue
            
            # 检测 msgid
            if line.startswith('msgid '):
                # 保存之前的条目
                if current_msgid and current_msgstr:
                    entries[current_msgid] = current_msgstr
                
                current_msgid = line[7:-1]  # 移除 msgid " 和 "
                current_msgstr = ''
                in_msgid = True
                in_msgstr = False
            
            # 检测 msgstr
            elif line.startswith('msgstr '):
                current_msgstr = line[8:-1]  # 移除 msgstr " 和 "
                in_msgid = False
                in_msgstr = True
            
            # 检测 msgctxt (跳过)
            elif line.startswith('msgctxt '):
                in_msgid = False
                in_msgstr = False
            
            # 继续多行字符串
            elif line.startswith('"'):
                content = line[1:-1]
                if in_msgid:
                    current_msgid += content
                elif in_msgstr:
                    current_msgstr += content
    
    # 保存最后一个条目
    if current_msgid and current_msgstr:
        entries[current_msgid] = current_msgstr
    
    return entries

def compile_mo_file(entries, mo_file):
    """将翻译条目编译为 MO 文件"""
    # MO 文件格式常量
    MAGIC = 0x950412de  # Little endian magic number
    
    # 构建字符串表
    keys = sorted(entries.keys())
    offsets = []
    ids = b''
    strs = b''
    
    for key in keys:
        # 编码为字节
        msgid = key.encode('utf-8')
        msgstr = entries[key].encode('utf-8')
        
        # 记录偏移和长度
        offsets.append((len(msgid), len(ids), len(msgstr), len(strs)))
        
        # 添加到字符串表
        ids += msgid + b'\x00'
        strs += msgstr + b'\x00'
    
    # 计算偏移
    keystart = 7 * 4 + 16 * len(keys)
    valuestart = keystart + len(ids)
    
    # 构建 MO 文件
    output = b''
    
    # 头部
    output += struct.pack('I', MAGIC)           # magic number
    output += struct.pack('I', 0)               # version
    output += struct.pack('I', len(keys))       # number of entries
    output += struct.pack('I', 7 * 4)           # offset of key index
    output += struct.pack('I', 7 * 4 + 8 * len(keys))  # offset of value index
    output += struct.pack('I', 0)               # size of hash table
    output += struct.pack('I', 0)               # offset of hash table
    
    # 键索引
    for o1, l1, o2, l2 in offsets:
        output += struct.pack('I', l1)          # length
        output += struct.pack('I', keystart + o1)  # offset
    
    # 值索引
    for o1, l1, o2, l2 in offsets:
        output += struct.pack('I', l2)          # length
        output += struct.pack('I', valuestart + o2)  # offset
    
    # 字符串表
    output += ids
    output += strs
    
    # 写入文件
    with open(mo_file, 'wb') as f:
        f.write(output)

def main():
    """主函数"""
    languages_dir = os.path.dirname(os.path.abspath(__file__))
    po_files = glob.glob(os.path.join(languages_dir, '*.po'))
    
    if not po_files:
        print("未找到 PO 文件")
        return 1
    
    print("开始编译翻译文件...\n")
    
    for po_file in po_files:
        mo_file = po_file.replace('.po', '.mo')
        
        try:
            entries = parse_po_file(po_file)
            compile_mo_file(entries, mo_file)
            print(f"成功编译: {os.path.basename(po_file)} -> {os.path.basename(mo_file)}")
        except Exception as e:
            print(f"错误: 编译 {os.path.basename(po_file)} 失败: {e}")
    
    print("\n编译完成!")
    return 0

if __name__ == '__main__':
    exit(main())
