<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    protected $table = 'wallets';

    /**
     * Esta função retorna a carteira baseado no hash;
     *
     * @return array|null
     */
    public function getWalletByHash(string $walletHash): ?array
    {
        $model = Wallet::where('wallet_hash', $walletHash)->first();
        return is_null($model) ? null : $model->toArray();
    }

    /**
     * Função que informa se o usuário tem saldo suficiente para fazer a transferencia.
     *
     * @param amount float
     * @return bool
     */
    public function hasBalance($walletId, $amount): bool
    {
        return $amount <= $this->getBalance($walletId);
    }

    /**
     * Função que retorna o valor disponivel na carteira do usuário.
     *
     * @return float
     */
    public function getBalance($walletId): float
    {
        $model = Wallet::find($walletId);
        $payerAmount = $model->payerTransactions()->sum('amount');
        $payeeAmount = $model->payeeTransactions()->sum('amount');
        return $payeeAmount - $payerAmount;
    }
}
