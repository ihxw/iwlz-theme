# IWLZ Theme 多语言支持说明

## 概述

IWLZ Theme 支持多语言翻译，默认提供以下语言：

- **中文（简体）** - 默认语言
- **English** - 英语
- **Deutsch** - 德语

## 文件结构

```
languages/
├── iwlz-theme.pot    # 翻译模板文件
├── en_US.po          # 英语翻译
├── de_DE.po          # 德语翻译
└── README.md         # 本文件
```

## 如何使用

### 1. 在 WordPress 中切换语言

1. 登录 WordPress 后台
2. 进入"设置" > "常规"
3. 在"站点语言"下拉菜单中选择语言
4. 保存更改

### 2. 添加新语言

如果您想添加新的语言翻译：

#### 方法 1：使用 Poedit（推荐）

1. 下载并安装 [Poedit](https://poedit.net/)
2. 打开 `iwlz-theme.pot` 文件
3. 选择"从 POT 文件创建新翻译"
4. 选择目标语言（如 fr_FR 代表法语）
5. 翻译所有字符串
6. 保存为 `fr_FR.po`
7. Poedit 会自动生成 `fr_FR.mo` 文件
8. 将 `.po` 和 `.mo` 文件上传到 `languages/` 目录

#### 方法 2：使用 Loco Translate 插件

1. 安装 [Loco Translate](https://wordpress.org/plugins/loco-translate/) 插件
2. 在 WordPress 后台进入"Loco Translate" > "主题"
3. 选择 "IWLZ Theme"
4. 点击"新建语言"
5. 选择目标语言并开始翻译
6. 保存翻译

### 3. 编译 MO 文件

`.po` 文件是可读的翻译文件，但 WordPress 需要编译后的 `.mo` 文件才能使用。

使用 Poedit 或命令行工具编译：

```bash
msgfmt en_US.po -o en_US.mo
msgfmt de_DE.po -o de_DE.mo
```

## 翻译的内容

主题中以下内容已准备好翻译：

- 导航菜单标签
- 侧边栏小工具标题
- 分页按钮文本
- 搜索表单占位符
- 评论区文本
- 页脚版权信息
- 错误提示信息
- 日期和时间格式

## 开发者信息

### 添加新的可翻译字符串

在 PHP 文件中使用以下函数：

```php
// 简单翻译
__( 'Text to translate', 'iwlz-theme' )

// 翻译并输出
_e( 'Text to translate', 'iwlz-theme' )

// 带占位符的翻译
printf( __( 'Hello %s', 'iwlz-theme' ), $name )

// 复数形式
_n( '%s item', '%s items', $count, 'iwlz-theme' )
```

### 更新 POT 文件

当添加新的可翻译字符串后，需要更新 POT 文件：

```bash
# 使用 WP-CLI
wp i18n make-pot . languages/iwlz-theme.pot

# 或使用 Poedit
# 打开 iwlz-theme.pot，选择"从源代码更新"
```

## 语言代码参考

常用语言代码：

- `zh_CN` - 简体中文
- `zh_TW` - 繁体中文
- `en_US` - 美式英语
- `en_GB` - 英式英语
- `de_DE` - 德语
- `fr_FR` - 法语
- `es_ES` - 西班牙语
- `ja` - 日语
- `ko_KR` - 韩语
- `ru_RU` - 俄语

## 贡献翻译

如果您想为主题贡献新的语言翻译：

1. Fork 主题仓库
2. 创建新的语言文件
3. 完成翻译
4. 提交 Pull Request

或直接发送翻译文件到：contact@iwlz.de

## 技术支持

如有翻译相关问题，请访问：
- 网站：https://iwlz.de
- 邮箱：contact@iwlz.de

## 许可证

翻译文件遵循与主题相同的 GPL v2 许可证。
