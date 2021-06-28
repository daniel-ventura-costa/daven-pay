<?php

namespace Tests\Unit\Services;

use App\Services\ExternalAuthorizerService;
use Tests\TestCase;

class TestExternalAuthorizerService extends TestCase
{
    public function testExternalAuthorizeReturnsBoolean()
    {
        $isAuthorized = (new ExternalAuthorizerService())->authorize();
        $this->assertTrue($isAuthorized);
    }
}
