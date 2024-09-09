# WPEssential Widgets

Help to register the widgets in WordPress.

`composer require wpessential-sidebars`

Add the single widget to WordPress registry

```php
$sidebar = \WPEssential\Library\Widget::make();
$sidebar->add('YOUR_NAMESPACE\CLASS_NAME');
$sidebar->init();
```

Add the multiple widgets to WordPress registry

```php
$sidebar = \WPEssential\Library\Widget::make();
$sidebar->adds(['YOUR_NAMESPACE\CLASS_NAME']);
$sidebar->init();
```

Remove the single widget from WordPress registry

```php
$sidebar = \WPEssential\Library\Widget::make();
$sidebar->remove('YOUR_NAMESPACE\CLASS_NAME');
$sidebar->init();
```

Remove the multiple widget from WordPress registry

```php
$sidebar = \WPEssential\Library\Widget::make();
$sidebar->removes(['YOUR_NAMESPACE\CLASS_NAME']);
$sidebar->init();
```
