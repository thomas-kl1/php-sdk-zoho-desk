# Zoho Desk PHP SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/tklein/php-sdk-zoho-desk.svg?style=flat-square)](https://packagist.org/packages/tklein/php-sdk-zoho-desk)
[![License: MIT](https://img.shields.io/github/license/thomas-kl1/php-sdk-zoho-desk.svg?style=flat-square)](./LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/tklein/php-sdk-zoho-desk.svg?style=flat-square)](https://packagist.org/packages/tklein/php-sdk-zoho-desk/stats)
[![Packagist](https://img.shields.io/packagist/dm/tklein/php-sdk-zoho-desk.svg?style=flat-square)](https://packagist.org/packages/tklein/php-sdk-zoho-desk/stats)

This SDK library 

 - [Setup](#setup)
 - [Features](#features)
 - [Settings](#settings)
 - [Documentation](#documentation)
 - [Support](#support)
 - [Authors](#authors)
 - [License](#license)

## Setup

```
composer require tklein/php-sdk-zoho-desk
```

## Features

You can execute all CRUD actions on all entities available in Zoho Desk.
Please check you have the allowed scope of operation with the proper registered OAuth access token.

## Settings

**All the basic constants settings are available in `\Zoho\Desk\Api\Metadata`.**

First you need to have a valid access token. First of all connect to your Zoho developer console from your region of
subscription:

for Europe the url is: [https://api-console.zoho.eu]

- Create or use an existing "Self Client" application. You may need these informations:
- Generate the grant code, with the proper scopes. ***`aaaserver.profile.READ` scope is mandatory***
- Generate the persistence auth token file with the Zoho SDK:
    - Client ID: you can find it in the Zoho api developer console
    - Client Secret: you can find it in the Zoho api developer console
    - Redirect url: this is a dummy url, it's part of the oauth standaard but not actively used
    - Current User Email: this is the user email used to create the self client integration (https://accounts.zoho.<domain from were you registered to>/oauth/user/info)
    - Org ID: this is your organization ID in your Zoho Desk application: Setup and Configuration -> DEVELOPER SPACE -> API -> Zoho Desk API -> OrgId (Orgnization ID) field value

```php
include __DIR__ . /* Relative path to the vendor autoloader */ '/vendor/autoload.php';

use Zoho\Desk\Api\Metadata;
use Zoho\Desk\Client\ConfigProviderBuilder;
use Zoho\OAuth\ZohoOAuth;

$configBuilder = ConfigProviderBuilder::getInstance();
$configBuilder->setClientId(/* Client ID */)
    ->setClientSecret(/* Client Secret */)
    ->setRedirectUrl(/* Redirect Url */)
    ->setCurrentUserEmail(/* User Email */)
    ->setApiBaseUrl(/* API Endpoint by region */)
    ->setApiVersion(Metadata::API_VERSION)
    ->setOrgId(/* Org ID */)
    ->setIsSandbox(/* Sandbox Status */)
    ->setAccountsUrl(/* Accounts Url */)
    ->setTokenPersistencePath(/* Persistence Path */);

// Add php code if the zcrm_oauthtokens.txt to create the file if it does not already exists.

ZohoOAuth::initialize($configBuilder->create()->get());
ZohoOAuth::getClientInstance()->generateAccessToken($grantCode);
```

Create the configuration object with your API details and credentials.

```php
include __DIR__ . /* Relative path to the vendor autoloader */ '/vendor/autoload.php';

use Zoho\Desk\Api\Metadata;
use Zoho\Desk\Client\ConfigProviderBuilder;

$configBuilder = ConfigProviderBuilder::getInstance();
$configBuilder->setClientId(/* Client ID */)
    ->setClientSecret(/* Client Secret */)
    ->setRedirectUrl(/* Redirect Url */)
    ->setCurrentUserEmail(/* User Email */)
    ->setApiBaseUrl(/* API Endpoint by region */)
    ->setApiVersion(Metadata::API_VERSION)
    ->setOrgId(/* Org ID */)
    ->setIsSandbox(/* Sandbox Status */)
    ->setAccountsUrl(/* Accounts Url */)
    ->setTokenPersistencePath(/* Persistence Path */);
```

You can use the following pre-defined values from the `Metadata` class:

```php
final class Metadata
{
    public const API_FIELD_CURRENT_USER_EMAIL = 'currentUserEmail';
    public const API_FIELD_BASE_URL = 'apiBaseUrl';
    public const API_FIELD_VERSION = 'apiVersion';
    public const API_ENDPOINT_US = 'desk.zoho.com/api';
    public const API_ENDPOINT_AU = 'desk.zoho.com.au/api';
    public const API_ENDPOINT_EU = 'desk.zoho.eu/api';
    public const API_ENDPOINT_IN = 'desk.zoho.in/api';
    public const API_ENDPOINT_CN = 'desk.zoho.com.cn/api';
    public const API_VERSION = 'v1';
    public const ACCESS_TYPE = 'offline';
    public const ORG_ID = 'orgId';
    public const API_ACCOUNTS_US = 'https://accounts.zoho.com';
    public const API_ACCOUNTS_AU = 'https://accounts.zoho.com.au';
    public const API_ACCOUNTS_EU = 'https://accounts.zoho.eu';
    public const API_ACCOUNTS_IN = 'https://accounts.zoho.in';
    public const API_ACCOUNTS_CN = 'https://accounts.zoho.com.cn';
}
```

## Documentation

The entry point of the SDK is the gateway facade:

```php
use Zoho\Desk\Gateway;

$gateway = new Gateway($configBuilder->create());
```

The facade is easy to use:

```php
use Zoho\Desk\Exception\CouldNotDeleteException;
use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Exception\CouldNotSaveException;
use Zoho\Desk\Model\ListCriteriaBuilder;

$ticketDataObject = $gateway->getDataObjectFactory()->create('tickets', /* Entity values */);

try {
    $ticketDataObject = $gateway->getOperationPool()->getCreateOperation('tickets')->create($ticketDataObject);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $gateway->getOperationPool()->getReadOperation('tickets')->get(1234);
} catch (CouldNotReadException $e) {
    // Handle the exception...
}

try {
    $criteriaBuilder = new ListCriteriaBuilder();
    // $criteriaBuilder->setFields()->setFilters()...
    $ticketList = $gateway->getOperationPool()->getListOperation('tickets')->getList($criteriaBuilder->create());
    $ticketList = $gateway->getOperationPool()->getListOperation('tickets')->getByIds([1,2,3]);
} catch (CouldNotReadException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $gateway->getOperationPool()->getUpdateOperation('tickets')->update($ticketDataObject);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $gateway->getOperationPool()->getDeleteOperation('tickets', ['resolution'])->delete(1234);
} catch (CouldNotDeleteException $e) {
    // Handle the exception...
}

```

## Support

Raise a new [request](https://github.com/thomas-kl1/php-sdk-zoho-desk/issues) to the issue tracker.

## Authors

- **Thomas Klein** - *Maintainer* - [![GitHub followers](https://img.shields.io/github/followers/thomas-kl1.svg?style=social)](https://github.com/thomas-kl1)
- **Contributors** - *Contributor* - [![GitHub contributors](https://img.shields.io/github/contributors/thomas-kl1/php-sdk-zoho-desk.svg?style=flat-square)](https://github.com/thomas-kl1/php-sdk-zoho-desk/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) details.

***That's all folks!***
