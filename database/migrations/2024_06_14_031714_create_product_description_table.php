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
            $table->foreignId("front_camera_id")->constrained("front_camera");
            $table->foreignId("rear_camera_id")->constrained("rear_camera");
            $table->foreignId("screen_id")->constrained("screen");
            $table->string("weight",3);
            $table->string("os",50);
            $table->string("battery",4);
            $table->string("ram",2);
            $table->string("chip",20);
            $table->string("sims",100);
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
