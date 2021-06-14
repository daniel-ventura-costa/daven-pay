<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table = 'transactions_type';

    public function transactions()
    {
        $this->hasMany(WalletTransaction::class, 'transaction_type_id');
    }
}
