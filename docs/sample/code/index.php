<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use Zoho\Desk\Api\Metadata;
use Zoho\Desk\Client\ConfigProviderBuilder;
use Zoho\Desk\Exception\CouldNotDeleteException;
use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Exception\CouldNotSaveException;
use Zoho\Desk\Gateway;

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

$gateway = new Gateway($configBuilder->create());

/** CRUD Operations **/

$ticketDataObject = $gateway->createDataObject('tickets', /* Entity values */);

try {
    $ticketDataObject = $gateway->create('tickets', $ticketDataObject);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $gateway->get('tickets', 1234);
} catch (CouldNotReadException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $gateway->update('tickets', $ticketDataObject);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $gateway->delete('tickets', 1234, ['resolution']);
} catch (CouldNotDeleteException $e) {
    // Handle the exception...
}
