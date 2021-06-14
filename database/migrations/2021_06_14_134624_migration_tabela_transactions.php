<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationTabelaTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_hash');
            $table->bigInteger('transactions_type_id')->unsigned();
            $table->float('amount');
            $table->bigInteger('payer_wallet_id')->unsigned();
            $table->bigInteger('payee_wallet_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payer_wallet_id')->references('id')->on('wallets');
            $table->foreign('payee_wallet_id')->references('id')->on('wallets');
            $table->foreign('transactions_type_id')->references('id')->on('transactions_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
