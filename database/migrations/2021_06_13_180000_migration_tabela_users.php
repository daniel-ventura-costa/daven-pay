<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationTabelaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_type_id')->unsigned();
            $table->string('name', 255);
            $table->string('cpf', 45)->unique();
            $table->string('cnpj', 45)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_type_id')->references('id')->on('users_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
