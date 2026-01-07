# IWLZ Theme
在线查看地址 [http://vps.iwlz.de](http://vps.iwlz.de)    
完全使用AI编写，参考[2Libra](https://2libra.com/auth/signup/j1NxL1)

## 主题特点

### 🎨 现代简约设计
- 卡片式布局，大圆角设计
- 柔和的视觉效果和优雅的交互动画

### 🌓 深色/浅色主题切换
- 支持浅色和深色两种主题模式
- 主题偏好自动保存到本地存储
- 支持键盘快捷键 (Ctrl/Cmd + K) 快速切换
- 自动检测系统主题偏好

### 📱 响应式设计
- 完美适配桌面、平板和手机
- 流畅的移动端体验

### ⚡ 性能优化
- 纯 CSS 实现，无需额外框架
- 轻量级设计，快速加载

## 安装方法

### 方法一：通过 WordPress 后台上传

1. 将整个 `iwlz-theme` 文件夹压缩为 ZIP 文件
2. 登录 WordPress 后台
3. 进入 **外观 > 主题**
4. 点击 **添加新主题**
5. 点击 **上传主题**
6. 选择压缩的 ZIP 文件并上传
7. 点击 **启用**

### 方法二：手动安装

1. 将 `iwlz-theme` 文件夹上传到 WordPress 安装目录的 `wp-content/themes/` 文件夹
2. 登录 WordPress 后台
3. 进入 **外观 > 主题**
4. 找到 **IWLZ Theme** 并点击 **启用**

## 主题配置

### 导航菜单设置

1. 进入 **外观 > 菜单**
2. 创建一个新菜单或编辑现有菜单
3. 在 **菜单设置** 中，勾选 **主导航菜单**
4. 保存菜单

### 小工具设置

1. 进入 **外观 > 小工具**
2. 在 **侧边栏** 区域添加您需要的小工具
3. 主题默认包含搜索框和主题切换器

### 自定义 Logo

1. 进入 **外观 > 自定义**
2. 点击 **站点标识**
3. 上传您的 Logo 图片

### 主题色设置

1. 进入 **外观 > 自定义**
2. 点击 **颜色**
3. 修改 **主题色** 为您喜欢的颜色

## 主题功能

### 支持的 WordPress 功能

- ✅ 自定义 Logo
- ✅ 自定义背景
- ✅ 导航菜单
- ✅ 文章缩略图
- ✅ 小工具区域
- ✅ HTML5 标记
- ✅ 自动 Feed 链接
- ✅ 标题标签管理

### 模板文件

- `index.php` - 主模板（文章列表）
- `single.php` - 单篇文章
- `page.php` - 页面
- `archive.php` - 归档页面
- `search.php` - 搜索结果
- `404.php` - 404 错误页面
- `comments.php` - 评论模板
- `header.php` - 头部
- `footer.php` - 页脚
- `sidebar.php` - 侧边栏

## 主题切换快捷键

- **Ctrl + K** (Windows/Linux) 或 **Cmd + K** (Mac) - 快速切换深色/浅色主题

## 浏览器支持

- Chrome (最新版)
- Firefox (最新版)
- Safari (最新版)
- Edge (最新版)

## 技术栈

- **WordPress** - 内容管理系统
- **PHP** - 服务器端语言
- **CSS3** - 样式和动画
- **JavaScript** - 主题切换功能

## 自定义开发

### CSS 变量

主题使用 CSS 变量系统，您可以在 `style.css` 中轻松自定义：

```css
:root {
  --bg-primary: #f5f5f7;
  --bg-secondary: #ffffff;
  --text-primary: #1a1a1a;
  --accent-color: #6419e6;
  /* 更多变量... */
}
```

### 深色主题变量

```css
[data-theme="dark"] {
  --bg-primary: #1a1d23;
  --bg-secondary: #242830;
  --text-primary: #e8e8e8;
  --accent-color: #7c3aed;
  /* 更多变量... */
}
```

## 常见问题

### 如何更改主题色？

进入 **外观 > 自定义 > 颜色**，修改主题色即可。

### 主题切换不工作？

请确保浏览器支持 localStorage 并且没有被禁用。

### 如何添加更多主题模式？

编辑 `js/theme-switcher.js` 和 `style.css`，添加新的主题变量和切换选项。

## 更新日志

### 1.0.0 (2026-01-07)
- 🎉 首次发布
- ✨ 深色/浅色主题切换
- ✨ 现代卡片式布局
- ✨ 响应式设计
- ✨ 完整的 WordPress 主题功能支持

## 许可证

本主题基于 [GPL v2 或更高版本](http://www.gnu.org/licenses/gpl-2.0.html) 许可证发布。


## 支持

如有问题或建议，请联系主题作者。

---

**享受使用 IWLZ Theme！** 🎨✨
