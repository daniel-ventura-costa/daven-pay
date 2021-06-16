<?php

namespace App\Exceptions;

/**
 * Classe de exceção para quando o sacado/pagador é do tipo lojista
 */
class PayerHasNoBalanceException extends CustomException
{
    protected $code = 400;
    protected $message = "Operação não permitida: o pagador não tem saldo suficiente.";
}
