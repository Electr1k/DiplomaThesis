<?php

namespace App\Service\DostavistaClients;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Класс HTTP-client для интеграции с Dostavista API
 */
class DostavistaClient
{
    private string $host;

    private int $timeout;

    private string $token;

    public const URI_V1_COURIER_PARTNERS = '/courier-partner/1.0/courier-partners';

    public const URI_V1_CREATE_COURIER = '/courier-partner/1.0/create-courier';

    public const URI_V1_COURIERS = '/courier-aggregator/1.1/couriers';

    public const URI_V1_ORDERS = '/courier-aggregator/1.1/orders';

    public const URI_V1_TRANSACTIONS = '/courier-aggregator/1.1/transactions';


    public function __construct()
    {
        /** @var string $host */
        $host = config('dostavista.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [dostavista.client.host]');
        }
        $this->host = $host;

        $timeout = config('dostavista.client.timeout');
        if (! $timeout) {
            throw new RuntimeException('Empty config [dostavista.client.timeout]');
        }
        if (! is_numeric($timeout)) {
            throw new RuntimeException('Config [dostavista.client.timeout] must be int');
        }
        $this->timeout = (int) $timeout;

        $token = config('dostavista.client.token');
        if (! $token) {
            throw new RuntimeException('Empty config [dostavista.client.token]');
        }
        $this->token = $token;
    }

    /**
     * Метод для отправки запроса
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

    /**
     * Метод для получения списка кабиентов
     */
    public function fetchCabinet(): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'GET',
            self::URI_V1_COURIER_PARTNERS
        );
    }

    /**
     * Метод для создания курьера
     */
    public function storeCourier(array $data): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_CREATE_COURIER,
            $data
        );
    }

    /**
     * Метод для получения списка заказов
     */
    public function fetchOrders(
        Carbon $dateFrom,
        Carbon $dateTo,
        ?int $nextPageId = null
    ): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_ORDERS,
            [
                'updated_datetime_from' => $dateFrom->toAtomString(),
                'updated_datetime_till' => $dateTo->toAtomString(),
                'next_page_id' => $nextPageId,
       ]
        );
    }

    /**
     * Метод для получения списка курьеров
     */
    public function fetchCouriers(?array $data = null): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_COURIERS,
            [
                "offset" => $data["offset"] ?? null,
                "limit" => $data["limit"] ?? null,
            ]
        );
    }

    /**
     * Метод для получения списка транзакций
     */
    public function fetchTransactions(
        Carbon $dateFrom,
        Carbon $dateTo,
        ?int $nextPageId = null
    ): array {
        /** @phpstan-ignore-next-line */
        return $this->makeRequest(
            'POST',
            self::URI_V1_TRANSACTIONS,
            [
                'updated_datetime_from' => $dateFrom->toAtomString(),
                'updated_datetime_till' => $dateTo->toAtomString(),
                'next_page_id' => $nextPageId,
            ]
        );
    }
}
