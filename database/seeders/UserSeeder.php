<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $user1 = User::create([
            'user_type_id' => '1',
            'name'         => $faker->name,
            'cpf'          => $faker->cpf(false),
            'email'        => $faker->email,
            'password'     => Hash::make('senha')
        ]);

        $wallet1 = Wallet::create([
            'user_id'     => $user1->id,
            'wallet_hash' => $faker->uuid
        ]);

        Transaction::create([
            'transaction_hash'     => $faker->uuid,
            'transactions_type_id' => 1,
            'amount'               => $faker->randomFloat(2, 50, 500),
            'payee_wallet_id'      => $wallet1->id
        ]);

        // ----

        $user2 = User::create([
            'user_type_id' => '1',
            'name'         => $faker->name,
            'cpf'          => $faker->cpf(false),
            'email'        => $faker->email,
            'password'     => Hash::make('senha')
        ]);

        $wallet2 = Wallet::create([
            'user_id'     => $user2->id,
            'wallet_hash' => $faker->uuid
        ]);

        Transaction::create([
            'transaction_hash'     => $faker->uuid,
            'transactions_type_id' => 1,
            'amount'               => $faker->randomFloat(2, 50, 500),
            'payee_wallet_id'      => $wallet2->id
        ]);


        // ----

        $user3 = User::create([
            'user_type_id' => '2',
            'name'         => $faker->company,
            'cnpj'         => $faker->cnpj(false),
            'email'        => $faker->companyEmail,
            'password'     => Hash::make('senha')
        ]);

        $wallet3 = Wallet::create([
            'user_id'     => $user3->id,
            'wallet_hash' => $faker->uuid
        ]);

        Transaction::create([
            'transaction_hash'     => $faker->uuid,
            'transactions_type_id' => 1,
            'amount'               => $faker->randomFloat(2, 50, 500),
            'payee_wallet_id'      => $wallet3->id
        ]);

    }
}
