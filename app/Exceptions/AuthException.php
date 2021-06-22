<?php

namespace App\Exceptions;

class AuthException extends CustomException
{
    protected $code = 404;
    protected $message = "User or password is wrong or not found";
}
