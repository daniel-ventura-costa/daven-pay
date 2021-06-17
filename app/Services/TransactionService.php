<?php

namespace App\Services;

use App\Exceptions\ExternalAuthorizerException;
use App\Exceptions\PayerHasNoBalanceException;
use App\Exceptions\PayerIsShopkeeperException;
use App\Exceptions\WalletOwnerException;
use App\Exceptions\WalletPayeeNotFoundException;
use App\Exceptions\WalletPayerNotFoundException;
use App\Models\Wallet;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ExternalAuthorizerService;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    private $amount;
    private $walletPayerHash;
    private $walletPayeeHash;

    public function __construct($amount, $walletPayerHash, $walletPayeeHash)
    {
        $this->amount = $amount;
        $this->walletPayerHash  = $walletPayerHash;
        $this->walletPayeeHash  = $walletPayeeHash;
    }

    public function transfer()
    {
        $walletPayerModel = (new WalletRepository())->getWalletByHash($this->walletPayerHash);
        $walletPayeeModel = (new WalletRepository())->getWalletByHash($this->walletPayeeHash);

        // Verificar se o amount é um numero e é maior que zero
        if (!$this->amount <= 0) {
            // "O valor a ser transferido precisa ser um numero válido e maior que zero"
        }

        if (is_null($walletPayerModel)) {
            throw new WalletPayerNotFoundException();
        }

        $userPayerModel = (new UserRepository())->getById($walletPayerModel["user_id"]);

        // Verificar se a pessoa que esta realizando a transferencia é a dona da carteira sacado/pagador
        if ($userPayerModel['id'] !== auth()->id()) {
            throw new WalletOwnerException();
        }

        // Se for lojista não pode fazer transferencia
        if ($userPayerModel['user_type_id'] == 2) {
            throw new PayerIsShopkeeperException();
        }

        // Verificar se a carteira do sacado/pagador tem saldo
        $hasBalance = (new WalletRepository())->hasBalance($walletPayerModel['id'], $this->amount);
        if (!$hasBalance) {
            throw new PayerHasNoBalanceException();
        }

        // Consulta a existencia da carteira do cedente/beneficiário
        if (is_null($walletPayeeModel)) {
            throw new WalletPayeeNotFoundException();
        }

        // Consulta o serviço autorizador externo
        $isAuthorized = (new ExternalAuthorizerService())->authorize();
        if (!$isAuthorized) {
            throw new ExternalAuthorizerException();
        }

        // Retirar o valor da conta do sacado/pagador e passa para o cedente/beneficiário
        $transactionModel = $walletPayerModel->payerTransactions()->create([
            'transaction_hash'     => Uuid::uuid4()->toString(),
            'transactions_type_id' => '3',
            'amount'               => $this->amount,
            'payee_wallet_id'      => $walletPayeeModel['id']
        ]);

        // Envia a notificação

        return $transactionModel;
    }
}
