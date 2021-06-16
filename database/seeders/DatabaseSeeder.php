<?php

namespace Database\Seeders;

use Database\Seeders\TransactionTypeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTypeSeeder::class,
            TransactionTypeSeeder::class,
            UserSeeder::class
        ]);
    }
}
