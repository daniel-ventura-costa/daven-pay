<?php

namespace App\Exceptions;

/**
 * Classe de exceção para quando o sacado/pagador é do tipo lojista
 */
class NotificationException extends CustomException
{
    protected $code = 400;
    protected $message = "Notificação não realizada.";
}
