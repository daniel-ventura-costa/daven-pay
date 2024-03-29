<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $table = 'transactions';
    protected $fillable = ['transaction_hash', 'transactions_type_id', 'amount', 'payer_wallet_id', 'payee_wallet_id'];
}
