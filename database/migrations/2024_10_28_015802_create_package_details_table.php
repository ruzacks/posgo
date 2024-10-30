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
        Schema::create('package_details', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->json('fixed_products')->nullable();
            $table->json('optional_products')->nullable();
            $table->json('optional_talents')->nullable();
            $table->integer('duration')->default(0);
            $table->string('location')->nullable();
            $table->integer('min_sale')->default(1);
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
        Schema::dropIfExists('package_details');
    }
};
