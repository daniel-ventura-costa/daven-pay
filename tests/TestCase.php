<?php

namespace Tests;

use App\Services\ExternalAuthorizerService;
use App\Services\TransactionService;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function callTransactionService($amount, $walletPayerHash, $walletPayeeHash)
    {
        $authorizorService = new ExternalAuthorizerService();
        return (new TransactionService($amount, $walletPayerHash, $walletPayeeHash, $authorizorService));
    }
}
