<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::create(['transaction_name' => "Deposito"]);
        TransactionType::create(['transaction_name' => "Saque"]);
        TransactionType::create(['transaction_name' => "Transferencia"]);
        TransactionType::create(['transaction_name' => "Extorno"]);
    }
}
