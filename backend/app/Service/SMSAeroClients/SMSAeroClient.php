<?php

namespace App\Service\SMSAeroClients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class SMSAeroClient
{
    private string $host;

    private string $email;

    private string $token;

    private string $sender;

    private const URI_SEND_MESSAGE = '/v2/sms/send';

    public function __construct()
    {
        /** @var string $host */
        $host = config('smsaero.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [smsaero.client.host]');
        }
        $this->host = $host;

        /** @var string $email */
        $email = config('smsaero.client.email');
        if (! $email) {
            throw new RuntimeException('Empty config [smsaero.client.host]');
        }
        $this->email = $email;

        $token = config('smsaero.client.token');
        if (! $token) {
            throw new RuntimeException('Empty config [smsaero.client.token]');
        }
        $this->token = $token;

        $sender = config('smsaero.client.sender');
        if (! $sender) {
            throw new RuntimeException('Empty config [smsaero.client.sender]');
        }
        $this->sender = $sender;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    private function makeRequest(
        string $method,
        string $url,
        array $data = []
    ): mixed {

        return Http::baseUrl("https://$this->email:$this->token$this->host")
            ->withQueryParameters($data)
            ->send($method, $url)
            ->throw()
            ->json();
    }

    /**
     * @throws Throwable
     */
    public function sendSms(string $phone, int $code): void {
        Log::info($this->sender);
        $this->makeRequest(
            'GET',
            self::URI_SEND_MESSAGE,
            [
                'number' => $phone,
                'text' => 'Ваш код: ' . $code,
                'sign' => $this->sender,
            ]
        );
    }

}
