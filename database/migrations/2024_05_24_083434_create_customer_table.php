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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->string("email",80);
            $table->string("password",100);
            $table->string("phone",10);
            $table->string("address",128);
            $table->boolean("status")->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
