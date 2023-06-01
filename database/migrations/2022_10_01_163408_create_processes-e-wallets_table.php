<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes-e-wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->boolean('charge');
            $table->boolean('pay');
            $table->unsignedBigInteger('e-wallet_id');
            $table->foreign('e-wallet_id')
                ->references('id')
                ->on('e-wallets')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes-e-wallets');
    }
};
