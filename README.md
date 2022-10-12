# This is my package filament-table-repeater

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-table-repeater)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/awcodes/filament-table-repeater/run-tests?label=tests)](https://github.com/awcodes/filament-table-repeater/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/awcodes/filament-table-repeater/Check%20&%20fix%20styling?label=code%20style)](https://github.com/awcodes/filament-table-repeater/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-table-repeater)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require awcodes/filament-table-repeater
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-table-repeater-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-table-repeater-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-table-repeater-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filament-table-repeater = new Awcodes\FilamentTableRepeater();
echo $filament-table-repeater->echoPhrase('Hello, Awcodes!');
```

## Testing

```bash
composer test
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
