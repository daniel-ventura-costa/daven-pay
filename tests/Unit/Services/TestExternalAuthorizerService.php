<?php

namespace Tests\Unit\Services;

use App\Services\ExternalAuthorizerService;
use Tests\TestCase;

class TestExternalAuthorizerService extends TestCase
{
    public function test_external_authorize_returns_boolean()
    {
        $isAuthorized = (new ExternalAuthorizerService())->authorize();
        $this->assertTrue($isAuthorized);
    }
}
