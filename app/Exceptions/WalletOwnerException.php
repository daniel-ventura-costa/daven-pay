<?php

namespace App\Exceptions;

class WalletOwnerException extends CustomException
{
    protected $code = 400;
    protected $message = "The logged user is not the owner of payer wallet";
}
