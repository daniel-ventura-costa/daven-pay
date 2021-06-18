<?php

namespace App\Services;

use App\Exceptions\ExternalAuthorizerException;
use App\Exceptions\PayerHasNoBalanceException;
use App\Exceptions\PayerIsShopkeeperException;
use App\Exceptions\WalletOwnerException;
use App\Exceptions\WalletPayeeNotFoundException;
use App\Exceptions\WalletPayerNotFoundException;
use App\Models\Transaction;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ExternalAuthorizerService;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    private $amount;
    private $walletPayerHash;
    private $walletPayeeHash;
    private $authorizerService;

    public function __construct($amount, $walletPayerHash, $walletPayeeHash, ExternalAuthorizerService $authorizerService)
    {
        $this->amount            = $amount;
        $this->walletPayerHash   = $walletPayerHash;
        $this->walletPayeeHash   = $walletPayeeHash;
        $this->authorizerService = $authorizerService;
    }

    public function transfer()
    {
        $walletPayerModel = (new WalletRepository())->getWalletByHash($this->walletPayerHash);
        $walletPayeeModel = (new WalletRepository())->getWalletByHash($this->walletPayeeHash);

        // Verificar se o amount é um numero e é maior que zero
        if ($this->amount <= 0) {
            throw new Exception("Amount needs to be greater than zero");
        }

        if (is_null($walletPayerModel)) {
            throw new WalletPayerNotFoundException();
        }

        $userPayerModel = (new UserRepository())->getById($walletPayerModel["user_id"]);

        // Verificar se a pessoa que esta realizando a transferencia é a dona da carteira sacado/pagador
        if ($userPayerModel['id'] != auth()->id()) {
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
        $isAuthorized = $this->authorizerService->authorize();
        if (!$isAuthorized) {
            throw new ExternalAuthorizerException();
        }

        // Retirar o valor da conta do sacado/pagador e passa para o cedente/beneficiário
        $transactionModel = $this->transferMoney($this->amount, $walletPayerModel['id'], $walletPayeeModel['id']);

        // Envia a notificação

        return $transactionModel;
    }

    private function transferMoney($amount, $walletPayerId, $walletPayeeId): bool
    {
        $transferType = 3;

        $arrayInsert = [
            'transaction_hash'     => Uuid::uuid4()->toString(),
            'transactions_type_id' => $transferType,
            'amount'               => $amount,
            'payer_wallet_id'      => $walletPayerId,
            'payee_wallet_id'      => $walletPayeeId,
            'created_at'           => Carbon::now()->toDateTimeString(),
            'updated_at'           => Carbon::now()->toDateTimeString(),
        ];

        return (new Transaction())->insert($arrayInsert);
    }
}
