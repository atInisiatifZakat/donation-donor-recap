# Small package for create donation recap in recording

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inisiatif/donation-donor-recap.svg?style=flat-square)](https://packagist.org/packages/inisiatif/donation-donor-recap)
[![PHPUnit](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/run-tests.yml)
[![Laravel Pint](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/fix-php-code-style-issues.yml)
[![Psalm](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/run-psalm-static-analyst.yml/badge.svg?branch=main)](https://github.com/atInisiatifZakat/donation-donor-recap/actions/workflows/run-psalm-static-analyst.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/inisiatif/donation-donor-recap.svg?style=flat-square)](https://packagist.org/packages/inisiatif/donation-donor-recap)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require inisiatif/donation-donor-recap
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="donation-donor-recap-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="donation-donor-recap-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="donation-donor-recap-views"
```

## Usage

```php
$donationRecap = new Inisiatif\DonationRecap();
echo $donationRecap->echoPhrase('Hello, Inisiatif!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nuradiyana](https://github.com/atInisiatifZakat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
