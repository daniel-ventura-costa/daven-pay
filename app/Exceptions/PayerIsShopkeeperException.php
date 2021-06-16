<?php

namespace App\Exceptions;

/**
 * Classe de exceção para quando o sacado/pagador é do tipo lojista
 */
class PayerIsShopkeeperException extends CustomException
{
    protected $code = 400;
    protected $message = "Operação não permitida: o pagador é um lojista";
}
