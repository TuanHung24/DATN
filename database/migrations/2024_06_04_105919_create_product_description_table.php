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
        Schema::create('product_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained("products");
            // $table->foreignId("brand_id")->constrained("brand");
            $table->foreignId("camera_id")->constrained("camera");
            $table->foreignId("screen_id")->constrained("screen");
            $table->string("weight",10);
            $table->string("os",50);
            $table->string("battery",5);
            $table->string("ram",5);
            $table->string("chip",50);
            $table->string("sims",50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_description');
    }
};
