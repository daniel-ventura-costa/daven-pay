<?php

namespace Tests\Unit\Controllers;

use App\Exceptions\AuthException;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    public function testLoginSuccess()
    {
        $url = env('APP_URL') . '/api/v1/login';

        $this->createUser();

        $parameters = [
            'email'    => "email@email.com",
            'password' => "password"
        ];

        $response = $this->call('post', $url, $parameters);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLoginPasswordIsWrong()
    {
        $url = env('APP_URL') . '/api/v1/login';
        $this->createUser();

        $parameters = [
            'email'    => "email@email.com",
            'password' => "password_wrong"
        ];

        $response = $this->call('post', $url, $parameters);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testUserLoginNotFound()
    {
        $url = env('APP_URL') . '/api/v1/login';

        $parameters = [
            'email'    => "email@email.com",
            'password' => "password"
        ];

        $response = $this->call('post', $url, $parameters);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
