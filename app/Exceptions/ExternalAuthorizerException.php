<?php

namespace App\Exceptions;

class ExternalAuthorizerException extends CustomException
{
    protected $code = 400;
    protected $message = "O serviço de autorização externo negou a transação.";
}
