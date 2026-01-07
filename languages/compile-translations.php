<?php
/**
 * 简单的 PO 到 MO 编译器
 * 用于将 .po 文件编译为 WordPress 可用的 .mo 文件
 */

function compile_po_to_mo($po_file, $mo_file)
{
    if (!file_exists($po_file)) {
        echo "错误: PO 文件不存在: $po_file\n";
        return false;
    }

    $po_content = file_get_contents($po_file);
    $lines = explode("\n", $po_content);

    $entries = array();
    $current_msgid = '';
    $current_msgstr = '';
    $in_msgid = false;
    $in_msgstr = false;

    foreach ($lines as $line) {
        $line = trim($line);

        // 跳过注释和空行
        if (empty($line) || $line[0] === '#') {
            continue;
        }

        // 检测 msgid
        if (strpos($line, 'msgid ') === 0) {
            // 保存之前的条目
            if (!empty($current_msgid) && !empty($current_msgstr)) {
                $entries[$current_msgid] = $current_msgstr;
            }

            $current_msgid = substr($line, 7, -1); // 移除 msgid " 和 "
            $current_msgstr = '';
            $in_msgid = true;
            $in_msgstr = false;
        }
        // 检测 msgstr
        elseif (strpos($line, 'msgstr ') === 0) {
            $current_msgstr = substr($line, 8, -1); // 移除 msgstr " 和 "
            $in_msgid = false;
            $in_msgstr = true;
        }
        // 检测 msgctxt (跳过)
        elseif (strpos($line, 'msgctxt ') === 0) {
            $in_msgid = false;
            $in_msgstr = false;
        }
        // 继续多行字符串
        elseif ($line[0] === '"') {
            $content = substr($line, 1, -1);
            if ($in_msgid) {
                $current_msgid .= $content;
            } elseif ($in_msgstr) {
                $current_msgstr .= $content;
            }
        }
    }

    // 保存最后一个条目
    if (!empty($current_msgid) && !empty($current_msgstr)) {
        $entries[$current_msgid] = $current_msgstr;
    }

    // 创建 MO 文件
    $mo_data = '';

    // MO 文件头部 (简化版本)
    $magic = 0x950412de; // Little endian magic number
    $revision = 0;
    $count = count($entries);

    // 构建字符串表
    $originals = '';
    $translations = '';
    $originals_table = array();
    $translations_table = array();

    $offset = 28; // 头部大小
    $offset += $count * 8 * 2; // 原文和译文的偏移表

    foreach ($entries as $msgid => $msgstr) {
        $originals_table[] = array(
            'length' => strlen($msgid),
            'offset' => $offset + strlen($originals)
        );
        $originals .= $msgid . "\0";

        $translations_table[] = array(
            'length' => strlen($msgstr),
            'offset' => $offset + strlen($originals) + strlen($translations)
        );
        $translations .= $msgstr . "\0";
    }

    // 写入 MO 文件
    $mo_data = pack('L', $magic);
    $mo_data .= pack('L', $revision);
    $mo_data .= pack('L', $count);
    $mo_data .= pack('L', 28); // 原文表偏移
    $mo_data .= pack('L', 28 + $count * 8); // 译文表偏移
    $mo_data .= pack('L', 0); // 哈希表大小
    $mo_data .= pack('L', 0); // 哈希表偏移

    // 写入原文表
    foreach ($originals_table as $entry) {
        $mo_data .= pack('L', $entry['length']);
        $mo_data .= pack('L', $entry['offset']);
    }

    // 写入译文表
    foreach ($translations_table as $entry) {
        $mo_data .= pack('L', $entry['length']);
        $mo_data .= pack('L', $entry['offset']);
    }

    // 写入字符串
    $mo_data .= $originals;
    $mo_data .= $translations;

    // 保存文件
    if (file_put_contents($mo_file, $mo_data) !== false) {
        echo "成功编译: $po_file -> $mo_file\n";
        return true;
    } else {
        echo "错误: 无法写入 MO 文件: $mo_file\n";
        return false;
    }
}

// 编译所有 PO 文件
$languages_dir = __DIR__;
$po_files = glob($languages_dir . '/*.po');

if (empty($po_files)) {
    echo "未找到 PO 文件\n";
    exit(1);
}

echo "开始编译翻译文件...\n\n";

foreach ($po_files as $po_file) {
    $mo_file = str_replace('.po', '.mo', $po_file);
    compile_po_to_mo($po_file, $mo_file);
}

echo "\n编译完成!\n";
