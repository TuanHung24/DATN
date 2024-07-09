<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vnp_TxnRef');
            $table->decimal('vnp_Amount',12,0);
            $table->string('vnp_BankCode');
            $table->string('vnp_BankTranNo');
            $table->string('vnp_CardType');
            $table->string('vnp_OrderInfo');

            $table->timestamp('vnp_PayDate');
            $table->string('vnp_ResponseCode');
            $table->string('vnp_TmnCode');

            $table->string('vnp_TransactionNo');
            $table->string('vnp_TransactionStatus');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};