<?php

namespace Tests\Unit\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function testTransferMoneyWithSuccess()
    {
        $userPayerModel = User::factory(['user_type_id' => 1])->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;

        $url = env('APP_URL') . '/api/v1/transaction';

        $parameters = [
            'amount'            => 10.00,
            'payer_wallet_hash' => $walletPayerHash,
            'payee_wallet_hash' => $walletPayeeHash
        ];

        $response = $this->call('post', $url, $parameters);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testNotAuthorizedWhenNotLogged()
    {
        $response = $this->call('get', '/api/v1/transaction');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testReturnSuccessfulTransactions()
    {
        $userModel = User::factory(['user_type_id' => 1])->create();
        $this->actingAs($userModel);

        $response = $this->call('get', '/api/v1/transaction');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testReturnGetTransactionsIsArray()
    {
        $userModel = User::factory()->create();
        $this->actingAs($userModel);

        $response = $this->call('get', '/api/v1/transaction');
        $this->assertJson($response->getContent());
    }
}
