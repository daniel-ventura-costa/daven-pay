<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table = 'transactions_type';
    protected $fillable = ['transaction_name'];
}
