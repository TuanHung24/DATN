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
        Schema::create('discount_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId("discount_id")->constrained("discount");
            $table->foreignId("product_id")->nullable()->constrained("products");
            $table->foreignId("product_detail_id")->nullable()->constrained("product_detail");
            $table->integer('percent');
            $table->decimal('price',10,0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_detail');
    }
};
