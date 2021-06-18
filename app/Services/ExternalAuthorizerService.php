<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExternalAuthorizerService
{
    private $url = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";

    /**
     * Função que retorna um booleano se o serviço autenticador externo voltar como Autorizado
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $client = new Client([
            'verify' => false
        ]);
        $response = $client->get($this->url);

        $contents = $response->getBody()->getContents();
        $jsonDecoded = json_decode($contents, true);

        return ($jsonDecoded["message"] == "Autorizado") ? true : false;
    }
}
