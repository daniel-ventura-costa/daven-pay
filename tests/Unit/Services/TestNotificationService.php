<?php

namespace Tests\Unit\Services;

use App\Services\NotificationService;
use Tests\TestCase;

class TestNotificationService extends TestCase
{
    public function test_notification_returns_success()
    {
        $isSuccess = (new NotificationService())->authorize();
        $this->assertTrue($isSuccess);
    }
}
