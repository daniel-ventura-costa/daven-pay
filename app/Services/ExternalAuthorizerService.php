<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExternalAuthorizerService
{
    private $url;

    public function __constuct()
    {
        $this->url = env('EXTERNAL_AUTHORIZER_SERVICE_URL');
    }

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
