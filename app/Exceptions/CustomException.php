<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $code = 400;
    protected $message = "Erro Genérico";
}
