<?php

namespace Tests\Unit\Controllers;

use App\Exceptions\PayerIsShopkeeperException;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ExternalAuthorizerService;
use App\Services\TransactionService;
use Exception;
use Mockery;
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

    public function testTransactionThrowCustomCustomException()
    {
        $userShopkeeperModel = User::factory(['user_type_id' => 2])->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userShopkeeperModel->wallet->wallet_hash;
        $this->actingAs($userShopkeeperModel);
        
        $userModel = User::factory()->has(Wallet::factory())->create();
        $walletPayeeHash = $userModel->wallet->wallet_hash;

        $parameters = [
            'amount'            => 10.00,
            'payer_wallet_hash' => $walletPayerHash,
            'payee_wallet_hash' => $walletPayeeHash
        ];

        $response = $this->call('post', '/api/v1/transaction', $parameters);
        $this->assertEquals(400, $response->getStatusCode());
    }
}
