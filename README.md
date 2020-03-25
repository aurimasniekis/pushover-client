# Pushover Client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

[![Email][ico-email]][link-email]

A PSR-18/17 based www.pushover.net client for sending messages & glances;


## Install

Via Composer

```bash
$ composer require aurimasniekis/pushover-client
```

## Usage

```php
<?php

use Buzz\Client\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;
use AurimasNiekis\PushoverClient\Client;
use AurimasNiekis\PushoverClient\Message;

$factory     = new Psr17Factory();
$httpClient  = new Curl($factory);

$client = new Client($httpClient, $factory, $factory, 'app-token', 'user-token');

$client->sendMessage(new Message('Hello World!'));
```

## Testing

Run PHP style checker

```bash
$ composer cs-check
```

Run PHP style fixer

```bash
$ composer cs-fix
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/aurimasniekis/pushover-client.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/com/aurimasniekis/pushover-client/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/aurimasniekis/pushover-client.svg?style=flat-square
[ico-email]: https://img.shields.io/badge/email-aurimas@niekis.lt-blue.svg?style=flat-square

[link-travis]: https://travis-ci.org/aurimasniekis/pushover-client
[link-packagist]: https://packagist.org/packages/aurimasniekis/pushover-client
[link-downloads]: https://packagist.org/packages/aurimasniekis/pushover-client/stats
[link-email]: mailto:aurimas@niekis.lt