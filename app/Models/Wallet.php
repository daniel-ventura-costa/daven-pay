<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $fillable = ['user_id', 'wallet_hash'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payerTransactions()
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id');
    }

    public function payeeTransactions()
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id');
    }
}
