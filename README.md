# PHPStan Faker Provider Extension

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Buy us a tree][ico-treeware]][link-treeware]
[![Total Downloads][ico-downloads]][link-downloads]
[![Maintained by SWIS][ico-swis]][link-swis]

This PHPStan Reflection Extension can automatically register the methods and properties created by custom Faker providers, so you don't need to instruct PHPStan to ignore the usage of those methods.

## Installation

Via Composer

```bash
composer require --dev swisnl/phpstan-faker
```

If you also have [phpstan/extension-installer](https://github.com/phpstan/extension-installer) installed, then you don't need to follow the instructions for manual installation. Regardless of the installation method, you need to follow the instructions for configuration.

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```neon
includes:
    - vendor/swisnl/phpstan-faker/extension.neon
```
</details>

## Configuration

Add the custom faker provider classes to the extension configuration.

```neon
parameters:
    faker:
        providerClasses:
            - App\Faker\MyProvider
```

**This does not actually register the custom providers in Faker, this just tells PHPStan about the custom providers.**

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@swis.nl instead of using the issue tracker.

## Credits

- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**][link-treeware] to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

## SWIS :heart: Open Source

[SWIS][link-swis] is a web agency from Leiden, the Netherlands. We love working with open source software.

[ico-version]: https://img.shields.io/packagist/v/swisnl/phpstan-faker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-treeware]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/swisnl/phpstan-faker.svg?style=flat-square
[ico-swis]: https://img.shields.io/badge/%F0%9F%9A%80-maintained%20by%20SWIS-%230737A9.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/swisnl/phpstan-faker
[link-downloads]: https://packagist.org/packages/swisnl/phpstan-faker
[link-treeware]: https://plant.treeware.earth/swisnl/phpstan-faker
[link-fork]: https://github.com/modprobe/phpstan-faker
[link-author]: https://github.com/modprobe
[link-contributors]: ../../contributors
[link-swis]: https://www.swis.nl
