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
use Zoho\Desk\Model\ListCriteria;
use Zoho\Desk\Model\ListCriteriaBuilder;
use Zoho\OAuth\ZohoOAuth;

// Optional, it's used by the zoho/oauth package
define('LOGGER_PATH', __DIR__ . '/');

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

$config = $configBuilder->create();
$gateway = new Gateway($config);
$serviceFactory = $gateway->getServiceFactory();

// Optional: if you need to register the token first
// ZohoOAuth::initialize($config->get());
// ZohoOAuth::getClientInstance()->generateAccessToken(/* Grant Code */);

/** CRUD Operations **/

$ticketDataObject = $gateway->getDataObjectFactory()->create('tickets', /* Entity values */);
$threadDataObject = $gateway->getDataObjectFactory()->create('threads', /* Entity values */);

try {
    $ticketDataObject = $serviceFactory->createOperation('tickets')->create($ticketDataObject);
    $threadDataObject = $serviceFactory->createOperation('threads', 'tickets/{ticket_id}/threads')->create($threadDataObject, ['ticket_id' => $ticketDataObject->getEntityId()]);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $serviceFactory->readOperation('tickets')->get([1234]);
    $threadDataObject = $serviceFactory->readOperation('threads', 'tickets/{ticket_id}/threads/{thread_id}')->get(['ticket_id' => 1234, 'thread_id' => 1234]);
} catch (CouldNotReadException $e) {
    // Handle the exception...
}

try {
    $criteriaBuilder = new ListCriteriaBuilder();
    // $criteriaBuilder->setFields(...)->setFilters(...)...
    $ticketList = $serviceFactory->listOperation('tickets')->getList($criteriaBuilder->create());
    $threadList = $serviceFactory->listOperation('threads', 'tickets/{ticket_id}/threads')->getList($criteriaBuilder->create(), ['ticket_id' => 1234]);
} catch (CouldNotReadException $e) {
    // Handle the exception...
}

try {
    $ticketDataObject = $serviceFactory->updateOperation('tickets')->update($ticketDataObject);
    $ticketDataObject = $serviceFactory->updateOperation('threads', 'tickets/{ticket_id}/threads/{thread_id}')->update($threadDataObject, ['ticket_id' => 1234, 'thread_id' => $threadDataObject->getEntityId()]);
} catch (CouldNotSaveException $e) {
    // Handle the exception...
}

try {
    $serviceFactory->deleteOperation('tickets', null, ['resolution'])->delete([1234]);
    $serviceFactory->deleteOperation('threads', 'tickets/{ticket_id}/threads/{thread_id}')->delete(['ticket_id' => 1234, 'thread_id' => 1234]);
} catch (CouldNotDeleteException $e) {
    // Handle the exception...
}
