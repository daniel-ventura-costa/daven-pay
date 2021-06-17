<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table = 'transactions_type';
    protected $fillable = ['transaction_name'];

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'transaction_type_id');
    }
}
