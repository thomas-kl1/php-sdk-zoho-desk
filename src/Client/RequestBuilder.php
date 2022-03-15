<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

use Zoho\OAuth\Utility\ZohoOAuthConstants;
use Zoho\Desk\Api\Metadata;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\OAuth\ClientInterface;

use function array_keys;
use function array_map;
use function array_merge;
use function array_values;
use function curl_init;
use function curl_setopt;
use function http_build_query;
use function is_array;
use function is_numeric;
use function json_encode;
use function sprintf;
use function str_replace;

use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_HEADER;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_URL;

/**
 * @api
 */
final class RequestBuilder
{
    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_PATCH = 'PATCH';
    public const HTTP_DELETE = 'DELETE';

    private const MANDATORY_FIELDS = ['path', 'method'];

    private ClientInterface $client;

    /**
     * @var resource
     */
    private $curl;

    /**
     * @var string[]
     */
    private array $mandatoryData;

    /**
     * @var array
     */
    private array $data;

    public function __construct(ClientInterface $client, array $mandatoryData = [])
    {
        $this->client = $client;
        $this->mandatoryData = array_merge(self::MANDATORY_FIELDS, $mandatoryData);
        $this->data = [];
    }

    /**
     * @deprecated
     */
    public function setEntityType(string $entityType): self
    {
        $this->data['path'] = $entityType;

        return $this;
    }

    public function setPath(string $path, array $bind = []): self
    {
        $search = array_map(static function (string $variable): string {
            return '{' . $variable . '}';
        }, array_keys($bind));

        $this->data['path'] = str_replace($search, array_values($bind), $path);

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->data['method'] = $method;

        return $this;
    }

    public function setArguments(array $arguments): self
    {
        $this->data['arguments'] = $arguments;

        return $this;
    }

    public function setQueryParameters(array $params): self
    {
        $this->data['queryParameters'] = $params;

        return $this;
    }

    public function setFields(array $fields): self
    {
        $this->data['fields'] = $fields;

        return $this;
    }

    /**
     * @return RequestInterface
     * @throws InvalidArgumentException|Exception
     */
    public function create(): RequestInterface
    {
        foreach ($this->mandatoryData as $mandatory) {
            if (!isset($this->data[$mandatory])) {
                throw InvalidArgumentException::createMandatoryFieldException($mandatory);
            }
        }

        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $this->buildUrl());
        curl_setopt($this->curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->buildHeaders());
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->data['method']);

        if ($this->data['method'] !== self::HTTP_GET) {
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data['fields']));
        }

        $request = new Request($this->curl);

        $this->curl = null;
        $this->data = [];

        return $request;
    }

    /**
     * @return string[]
     * @throws Exception
     */
    private function buildHeaders(): array
    {
        $headers = [
            ZohoOAuthConstants::AUTHORIZATION . ':' . ZohoOAuthConstants::OAUTH_HEADER_PREFIX . $this->client->getAccessToken(),
            'Content-Type:application/json'
        ];

        if ($this->client->getOrgId()) {
            $headers[] = Metadata::ORG_ID . ':' . $this->client->getOrgId();
        }

        return $headers;
    }

    private function buildUrl(): string
    {
        $url = sprintf(
            'https://%s/%s/%s',
            $this->client->getApiBaseUrl(),
            $this->client->getApiVersion(),
            $this->data['path']
        );

        if (isset($this->data['arguments']) && is_array($this->data['arguments'])) {
            foreach ($this->data['arguments'] as $key => $argument) {
                if (!is_numeric($key)) {
                    $url .= '/' . $key;
                }
                $url .= '/' . $argument;
            }
        }
        if (isset($this->data['queryParameters']) && is_array($this->data['queryParameters'])) {
            $url .= '?' . http_build_query($this->data['queryParameters']);
        }

        return $url;
    }
}
