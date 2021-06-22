<?php

namespace App\Jobs;

use App\Exceptions\NotificationException;
use App\Services\NotificationService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;

class TransferMoneyJob extends Job
{
    private $amount;
    private $walletPayerModelId;
    private $walletPayeeModelId;

    public function __construct($amount, $walletPayerModelId, $walletPayeeModelId)
    {
        $this->amount             = $amount;
        $this->walletPayerModelId = $walletPayerModelId;
        $this->walletPayeeModelId = $walletPayeeModelId;
    }

    public function handle()
    {
        // Retirar o valor da conta do sacado/pagador e passa para o cedente/beneficiário
        $transactionService = new TransactionService($this->amount, $this->walletPayerModelId, $this->walletPayeeModelId);
        $transactionService->makeTransaction();

        // Consulta o serviço de notificação externo
        $isSuccess = (new NotificationService())->notify();
        if (!$isSuccess) {
            throw new NotificationException();
        }

        Log::debug('Transferencia efetuada com sucesso.');
    }
}
