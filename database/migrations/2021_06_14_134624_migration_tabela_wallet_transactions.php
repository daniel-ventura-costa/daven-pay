<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationTabelaWalletTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_hash');
            $table->bigInteger('transaction_type_id')->unsigned();
            $table->float('amount');
            $table->bigInteger('payer_wallet_id')->unsigned();
            $table->bigInteger('payee_wallet_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payer_wallet_id')->references('id')->on('wallet');
            $table->foreign('payee_wallet_id')->references('id')->on('wallet');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
