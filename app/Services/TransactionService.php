<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    private $amount;
    private $walletPayerModelId;
    private $walletPayeeModelId;

    public function __construct($amount, $walletPayerModelId, $walletPayeeModelId)
    {
        $this->amount            = $amount;
        $this->walletPayerModelId   = $walletPayerModelId;
        $this->walletPayeeModelId   = $walletPayeeModelId;
    }

    public function makeTransaction(): bool
    {
        $transferType = 3;

        $arrayInsert = [
            'transaction_hash'     => Uuid::uuid4()->toString(),
            'transactions_type_id' => $transferType,
            'amount'               => $this->amount,
            'payer_wallet_id'      => $this->walletPayerModelId,
            'payee_wallet_id'      => $this->walletPayeeModelId,
            'created_at'           => Carbon::now()->toDateTimeString(),
            'updated_at'           => Carbon::now()->toDateTimeString(),
        ];

        return (new Transaction())->insert($arrayInsert);
    }
}
