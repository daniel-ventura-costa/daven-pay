<?php

namespace App\Exceptions;

class WalletPayeeNotFoundException extends CustomException
{
    protected $code = 400;
    protected $message = "Carteira do cedente/beneficiário não encontrada";
}
