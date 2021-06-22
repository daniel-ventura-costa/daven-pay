<?php

namespace App\Services;

use GuzzleHttp\Client;

class NotificationService
{
    private $url;

    public function __construct()
    {
        $this->url = env('NOTIFICATION_SERVICE_URL');
    }

    /**
     * Função que retorna um booleano se o serviço notificador externo voltar como Success
     *
     * @return bool
     */
    public function notify(): bool
    {
        $client = new Client([
            'verify' => false
        ]);
        $response = $client->get($this->url);

        $contents = $response->getBody()->getContents();
        $jsonDecoded = json_decode($contents, true);

        return ($jsonDecoded["message"] == "Success") ? true : false;
    }
}
