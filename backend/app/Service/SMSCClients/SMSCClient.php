<?php

namespace App\Service\SMSCClients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class SMSCClient
{
    private string $host;

    private string $login;

    private string $password;

    private const URI_SEND_MESSAGE = '/sys/send.php';

    public function __construct()
    {
        /** @var string $host */
        $host = config('smsc.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [smsc.client.host]');
        }
        $this->host = $host;

        $login = config('smsc.client.login');
        if (! $login) {
            throw new RuntimeException('Empty config [smsc.client.login]');
        }
        $this->login = $login;

        $password = config('smsc.client.password');
        if (! $password) {
            throw new RuntimeException('Empty config [smsc.client.password]');
        }
        $this->password = $password;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $queryParameters
     *
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    private function makeRequest(
        string $method,
        string $url,
        array $queryParameters = []
    ): mixed {
        $params = [
            'login' => $this->login,
            'psw' => $this->password,
        ];

        return Http::baseUrl($this->host)
            ->withQueryParameters(array_merge($queryParameters, $params))
            ->send($method, $url)
            ->throw()
            ->json();
    }

    /**
     * @throws Throwable
     */
    public function flashCall(string $phone, int $code): void {
        $this->makeRequest(
            'GET',
            self::URI_SEND_MESSAGE,
            [
                'phone' => $phone,
                'mes' => 'Ваш код: ' . $code,
                'call' => 1
            ]
        );
    }

}
