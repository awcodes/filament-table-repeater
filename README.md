# Table Repeater Plugin

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-table-repeater)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-table-repeater)

<img src="https://res.cloudinary.com/aw-codes/image/upload/w_1200,f_auto,q_auto/plugins/table-repeater/awcodes-table-repeater.jpg" alt="table repeater opengraph image" width="1200" height="auto" class="filament-hidden" style="width: 100%;" />

## Upgrade Guide for 2.x to 3.x

1. Rename you use statements from `Awcodes\FilamentTableRepeater` to `Awcodes\TableRepeater`.
2. Run `npm run build` to update your theme file.
3. See [Headers](#headers) for changes to the `headers()` method.

## Installation

You can install the package via composer:

```bash
composer require awcodes/filament-table-repeater
```

In an effort to align with Filament's theming methodology you will need to use a custom theme to use this plugin.

> [!IMPORTANT]
> If you have not set up a custom theme and are using a Panel follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first. The following applies to both the Panels Package and the standalone Forms package.

1. Import the plugin's stylesheet in your theme's css file.

```css
@import '<path-to-vendor>/awcodes/filament-table-repeater/resources/css/plugin.css';
```

2. Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    '<path-to-vendor>/awcodes/filament-table-repeater/resources/**/*.blade.php',
]
```

## Usage

This field has most of the same functionality of the [Filament Forms Repeater](https://filamentphp.com/docs/3.x/forms/fields/repeater) field. The main exception is that this field can not be collapsed.

```php
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;

TableRepeater::make('users')
     ->headers([
        Header::make('name')->width('150px'),
    ])
    ->schema([
        ...
    ])
    ->columnSpan('full')
```

### Headers

To add headers use the `headers()` method. and pass in an array of `Header` components.

```php
use Awcodes\TableRepeater\Header;

TableRepeater::make('users')
    ->headers([
        Header::make('name'),
        Header::make('email'),
    ])
```

#### Header Alignment

To align the headers of the table use the `align()` method, passing in one of the Filament Alignment enums.

```php
use Filament\Support\Enums\Alignment;

Header::make('name')
    ->align(Alignment::Center)
```

#### Header Width

To set the width of the headers of the table use the `width()` method.

```php
Header::make('name')
    ->width('150px')
```

#### Marking Columns as Required

To mark a column as required use the `markAsRequired()` method.

```php
Header::make('name')
    ->markAsRequired()
```

#### Hiding the header

Even if you do not want to show a header, you should still add them to be compliant with accessibility standards. You can hide the header though with the `renderHeader()` method.

```php
TableRepeater::make('users')
    ->headers(...)
    ->renderHeader(false)
```

### Labels

By default, form component labels will be set to hidden. To show them use the `showLabels()` method.

```php
TableRepeater::make('users')
    ->showLabels()
```

### Empty State Label

To customize the text shown when the table is empty, use the `emptyLabel()` method.

```php
TableRepeater::make('users')
    ->emptyLabel('There are no users registered.')
```

Alternatively, you can hide the empty label with `emptyLabel(false)`.

### Break Point

Below a specific break point the table will render as a set of panels to 
make working with data easier on mobile devices. The default is 'md', but 
can be overridden with the `stackAt()` method.

```php
use Filament\Support\Enums\MaxWidth;

TableRepeater::make('users')
    ->stackAt(MaxWidth::Medium)
```

### Appearance

If you prefer for the fields to be more inline with the table. You can change the appearance of the table with the `streamlined()` method.

```php
TableRepeater::make('users')
    ->streamlined()
```

### Extra Actions

TableRepeater supports the same `extraItemActions()` as the native Filament repeater. You may also add extra actions below the table with the `extraActions()` method. These will appear next to the 'Add' button or in place of the 'Add' button if it is hidden.

```php
TableRepeater::make('users')
    ->extraActions([
        Action::make('exportData')
            ->icon('heroicon-m-inbox-arrow-down')
            ->action(function (TableRepeater $component): void {
                Notification::make('export_data')
                    ->success()
                    ->title('Data exported.')
                    ->send();
            }),
    ])
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
