<?php

namespace App\Exceptions;

class WalletPayerNotFoundException extends CustomException
{
    protected $code = 400;
    protected $message = "Carteira do sacado/pagador não encontrada";
}
