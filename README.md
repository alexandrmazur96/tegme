# Telegraph me.
[![Packagist](https://img.shields.io/packagist/v/tegme/tegme)](https://packagist.org/packages/tegme/tegme)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

Tegme is pretty simple in use and lightweight client for [api.telegra.ph](https://api.telegra.ph).

Original API description you can find [here](https://telegra.ph/api).

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Author](#author)
- [License](#license)

## Installation

`$ composer require tegme/tegme`

## Requirements

All extension dependencies defined in *composer.json*:

- [cURL](https://www.php.net/manual/en/book.curl.php) - we need it for making requests to telegra.ph API;
- [JSON](https://www.php.net/manual/en/book.json.php) - we need it for create requests data for querying telegra.ph API;
- [mbstring](https://www.php.net/manual/en/book.mbstring.php) - we need it for interaction with multi-byte strings;
- [PHP >= 5.6](https://www.php.net) - code of this library compatible with PHP since 5.6.

## Usage

First of all - you should create a client object:

```php
use Tegme\Telegraph;

$telegraphClient = new Telegraph();
```

Then - you should create one of the request object, defined in `Tegme\Types\Requests\*`, e.g.:

```php
use Tegme\Types\Requests\CreateAccount;

$createAccountRequest = new CreateAccount(
    'Example Short Name',
    'Author Name',
    'https://t.me/author_url'
);
```
Note, that some of requests objects will validate in constructor and may throw exception (`Tegme\Exceptions\InvalidRequestsInfoException`).

See the exception message about detailed information.

Next step - let's call api.telegra.ph:

```php
/**
 * @var TelegraphResponse $response
 */
$response = $telegraphClient->call($createAccountRequest);
```

`Tegme\Types\TelegraphResponse` - is simple wrapper for raw response. 

You can get one of the Telegraph type (`Tegme\Types\Response\*`) via:

```php
/** @var mixed $resultObj */
$resultObj = $response->getResult();
```

or raw response in array format:

```php
/** @var array $rawResponse */
$rawResponse = $response->getRawResponse();
```

Note that telegraph client may throw exceptions (`Tegme\Exceptions\{TelegraphApiException, CurlException}`) while querying on api.telegra.ph

See exceptions messages about detailed information.

-----------

You can find all possible client usage [here (example folder)](https://github.com/alexandrmazur96/tegme/tree/master/example).  

### Author

Mazur Alexandr - alexandrmazur96@gmail.com - https://t.me/alexandrmazur96

### License

Tegme is licensed under the GNU General Public License - see the LICENSE file for details.