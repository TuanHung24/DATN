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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer');
            $table->string("phone",10);
            $table->string("address",128)->nullable();
            $table->decimal("total",12,0)->nullable();
            $table->string("payment_method",60);
            $table->string("note",255)->nullable();
            $table->unsignedSmallInteger("status")->default(1);
            $table->decimal('ship',10,0)->nullable();
            $table->timestamp("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
