<?php

namespace Tests\Unit;

use App\Exceptions\ExternalAuthorizerException;
use App\Exceptions\PayerHasNoBalanceException;
use App\Exceptions\PayerIsShopkeeperException;
use App\Exceptions\WalletOwnerException;
use App\Exceptions\WalletPayeeNotFoundException;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ExternalAuthorizerService;
use App\Services\TransactionService;
use App\Services\TransferService;
use Exception;
use Mockery;
use Tests\TestCase;

class TransferTest extends TestCase
{
    
    public function testIfUserIsShopkeeperTransferIsNotAllowed()
    {
        $amount = 10.00;

        $userPayerModel = User::factory(['user_type_id' => 2])->has(Wallet::factory(), 'wallet')->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;

        $this->expectException(PayerIsShopkeeperException::class);
        $this->expectExceptionMessage('Operação não permitida: o pagador é um lojista');

        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }

    public function testAmountBelowZero()
    {
        $amount = -1;
        $walletPayerHash = '1234';
        $walletPayeeHash = '4321';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Amount needs to be greater than zero');

        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }

    public function testLoggedUserIsNotTheOwnerOfThePayerWallet()
    {
        $amount = 10.00;

        $userPayerModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;
        $this->actingAs($userPayeeModel);

        $this->expectException(WalletOwnerException::class);
        $this->expectExceptionMessage('The logged user is not the owner of payer wallet');

        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }

    public function testPayerHasNotBalance()
    {
        $amount = 200;

        $userPayerModel = User::factory()->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;

        $this->expectException(PayerHasNoBalanceException::class);
        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }

    public function testPayeeHasWallet()
    {
        $amount = 50;

        $userPayerModel = User::factory()->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $walletPayeeHash = 'hash_nao_existe';

        $this->expectException(WalletPayeeNotFoundException::class);
        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }

    public function testExternalServiceNotAllowed()
    {
        $amount = 50;
        $authorizorService = $this->createMock(ExternalAuthorizerService::class);
        $authorizorService->method('authorize')->willReturn(false);

        $userPayerModel = User::factory()->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;

        $this->expectException(ExternalAuthorizerException::class);
        (new TransferService($amount, $walletPayerHash, $walletPayeeHash, $authorizorService))->transfer();
    }

    public function testTransHasSuccess()
    {
        $amount = 50;

        $userPayerModel = User::factory()->has(
            Wallet::factory()->has(Transaction::factory(['amount' => 100]), 'payeeTransactions'),
            'wallet'
        )->create();
        $walletPayerHash = $userPayerModel->wallet->wallet_hash;
        $this->actingAs($userPayerModel);

        $userPayeeModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletPayeeHash = $userPayeeModel->wallet->wallet_hash;

        $hasSuccess = $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
        $this->assertTrue($hasSuccess);
    }
}
