<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExternalAuthorizerService
{
    /**
     * Função que retorna um booleano se o serviço autenticador externo voltar como Autorizado
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $url = env('EXTERNAL_AUTHORIZER_SERVICE_URL');

        $client = new Client([
            'verify' => false
        ]);
        $response = $client->get($url);

        $contents = $response->getBody()->getContents();
        $jsonDecoded = json_decode($contents, true);

        return ($jsonDecoded["message"] == "Autorizado") ? true : false;
    }
}
