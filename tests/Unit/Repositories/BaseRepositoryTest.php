<?php

namespace Tests\Unit\Repositories;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class BaseRepositoryTest extends TestCase
{
    public function testIfInsertUserReturnsTrue()
    {
        $faker = Faker::create('pt_BR');
        $array = [
            'user_type_id' => 1,
            'name'       => $faker->name(),
            'cpf'        => $faker->cpf(),
            'email'      => $faker->email(),
            'password'   => Hash::make('password'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $hasInserted = (new UserRepository())->insert($array);
        $this->assertTrue($hasInserted);
    }
}
