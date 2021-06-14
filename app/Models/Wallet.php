<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
