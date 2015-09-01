# :package_name

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

An adaptation of the Specification Pattern as done by https://github.com/domnikl/DesignPatternsPHP, adding an artisan command to quickly make specifications.

## Install

Via Composer

``` bash
$ composer require timothyteoh/laravel-specification
```
Then run `composer update`. Once composer finished add the service provider to the `providers` array in `app/config/app.php`:
```
Chalcedony\Specification\Providers\SpecificationServiceProvider::class
```

## Usage

A command will be created to create specifications.
``` php
php artisan make:specification [NameOfSpecification]
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

## Credits

- [Dominic Liebler][https://github.com/domnikl/DesignPatternsPHP]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
