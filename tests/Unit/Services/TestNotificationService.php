<?php

namespace Tests\Unit\Services;

use App\Services\NotificationService;
use Tests\TestCase;

class TestNotificationService extends TestCase
{
    public function testNotificationReturnsSuccess()
    {
        $isSuccess = (new NotificationService())->authorize();
        $this->assertTrue($isSuccess);
    }
}
