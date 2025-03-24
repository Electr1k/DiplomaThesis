<?php

namespace App\Service\DostavistaClients;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class DostavistaClient
{
    private string $host;

    private int $timeout;

    private string $token;

    private const URI_V1_COURIER_PARTNERS = '/1.0/courier-partners';

    private const URI_V1_INDEX = '/1.0/index';

    private const URI_V1_CREATE_COURIER = '/1.0/create-courier';

    private const URI_V1_COURIERS = '/1.1/couriers';

    private const URI_V1_ORDERS = '/1.1/orders';


    public function __construct()
    {
        /** @var string $host */
        $host = config('dostavista.client.host');
        $this->host = $host;

        $timeout = config('dostavista.client.timeout');
        if (! $timeout) {
            throw new RuntimeException('Empty config [dostavista.client.timeout]');
        }
        if (! is_int($timeout)) {
            throw new RuntimeException('Config [dostavista.client.timeout] must be int');
        }
        $this->timeout = $timeout;
    }

    /**
     * @param  array<mixed>  $data
     * @param  array<mixed>  $additionalHeaders
     * @param  array<mixed>  $queryParameters
     * @return array<mixed>
     *
     * @throws Throwable
     */
    private function makeRequest(
        string $method,
        string $url,
        array $data = [],
        array $additionalHeaders = [],
        array $queryParameters = []
    ): array {
        $headers = [
            'X-DV-Auth-Token' => $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = Http::baseUrl($this->host)
            ->timeout($this->timeout)
            ->withQueryParameters($queryParameters)
            ->withHeaders($headers)
            ->withHeaders($additionalHeaders)
            ->send($method, $url, ['json' => $data])
            ->throw()
            ->json();

        if (! is_array($response)) {
            throw new RuntimeException('Unexpected response from dostavista');
        }

        return $response;
    }

    public function fetchCabinet(): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'GET',
            self::URI_V1_COURIER_PARTNERS
        );
    }

    public function storeCourier(array $data): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_CREATE_COURIER,
            $data
        );
    }

    public function fetchOrders(array $data): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_CREATE_COURIER,
            $data
        );
    }

    public function fetchCouriers(array $data): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_COURIERS,
            [
                "offset" => $data["offset"] ?? null,
                "limit" => $data["limit"] ?? null,
            ]
        )['couriers'];
    }
}
