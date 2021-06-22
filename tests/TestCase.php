<?php

namespace Tests;

use App\Repositories\UserRepository;
use App\Services\ExternalAuthorizerService;
use App\Services\TransferService;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    public function createUser()
    {
        $faker = Faker::create('pt_BR');
        $array = [
            'user_type_id' => 1,
            'name'       => $faker->name(),
            'cpf'        => $faker->cpf(),
            'email'      => "email@email.com",
            'password'   => Hash::make('password'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        (new UserRepository())->insert($array);
    }

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
        return (new TransferService($amount, $walletPayerHash, $walletPayeeHash, $authorizorService));
    }
}
