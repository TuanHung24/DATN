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
        Schema::create('warehouse_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouse');         
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('color_id')->constrained('colors');
            $table->foreignId('capacity_id')->constrained('capacity');     
            $table->integer("quanlity");
            $table->decimal("in_price",10,0);
            $table->decimal("out_price",10,0);
            $table->decimal("into_money",12,0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_detail');
    }
};
