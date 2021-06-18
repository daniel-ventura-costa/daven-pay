<?php

namespace Tests\Unit;

use App\Exceptions\WalletPayerNotFoundException;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\TransactionService;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function test_if_wallet_has_balance()
    {
        $amount = 100;

        $userModel = User::factory()->has(
            Wallet::factory()->has(
                Transaction::factory(['amount' => 100]),
                'payeeTransactions'
            ),
            'wallet'
        )->create();
        $walletModel = $userModel->wallet;

        $hasBalance = (new WalletRepository())->hasBalance($walletModel['id'], $amount);
        $this->assertTrue($hasBalance);
    }

    public function test_if_wallet_has_no_balance()
    {
        $amount = 10;

        $userModel = User::factory()->has(Wallet::factory(), 'wallet')->create();
        $walletModel = $userModel->wallet;

        $hasBalance = (new WalletRepository())->hasBalance($walletModel['id'], $amount);
        $this->assertFalse($hasBalance);
    }

    public function test_wallet_payer_not_found()
    {
        $amount = 10.00;
        $walletPayerHash = '1234';
        $walletPayeeHash = '4321';

        $this->expectException(WalletPayerNotFoundException::class);
        $this->expectExceptionMessage('Carteira do sacado/pagador não encontrada');

        $this->callTransactionService($amount, $walletPayerHash, $walletPayeeHash)->transfer();
    }
}
