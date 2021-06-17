<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Ramsey\Uuid\Uuid;

class WalletController extends Controller
{
    public function create()
    {
        $uuid = Uuid::uuid4();

        $walletModel = Wallet::create([
            'user_id' => '6',
            'wallet_hash' => $uuid->toString()
        ]);

        return response()
                ->json($walletModel, 201);
    }

    public function read()
    {
        $walletModel = Wallet::all();
        return response()
                ->json($walletModel, 200);
    }

    public function update()
    {

    }

    public function delete()
    {
        
    }
}
