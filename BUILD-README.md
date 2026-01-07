# 主题打包说明

## 快速开始

### 方法 1：双击运行（推荐）
1. 双击 `build-theme.bat` 文件
2. 等待打包完成
3. 在父文件夹中找到 `iwlz-theme.zip`

### 方法 2：PowerShell
1. 右键点击 `build-theme.ps1`
2. 选择"使用 PowerShell 运行"
3. 或在 PowerShell 中执行：
   ```powershell
   .\build-theme.ps1
   ```

## 输出文件

打包脚本会生成两个文件：

- `iwlz-theme.zip` - 主题包（用于上传到 WordPress）
- `iwlz-theme-YYYYMMDD-HHMMSS.zip` - 带时间戳的备份

## 排除的文件

以下文件和文件夹不会包含在 ZIP 包中：

- `*.ps1` - PowerShell 脚本
- `*.md` - Markdown 文档
- `.git` - Git 仓库
- `.gitignore` - Git 配置
- `node_modules` - Node.js 依赖
- `.DS_Store` - macOS 系统文件
- `Thumbs.db` - Windows 缩略图
- `*.zip` - 已有的 ZIP 文件

## 上传到 WordPress

1. 登录 WordPress 后台
2. 进入"外观" > "主题"
3. 点击"添加新主题"
4. 点击"上传主题"
5. 选择 `iwlz-theme.zip` 文件
6. 点击"现在安装"
7. 安装完成后点击"启用"

## 故障排除

### PowerShell 执行策略错误

如果遇到执行策略错误，请以管理员身份运行 PowerShell 并执行：

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

### 权限问题

确保您对主题文件夹和父文件夹有读写权限。

## 版本历史

- v1.0.1 - 2026-01-07
  - 初始版本
  - 支持自动排除开发文件
  - 自动创建带时间戳的备份
