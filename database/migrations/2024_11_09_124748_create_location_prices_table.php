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
        Schema::create('location_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('location_type_id');
            $table->integer('duration');
            $table->biginteger('price');
            $table->timestamps();

            $table->unique(['location_type_id', 'duration']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_prices');
    }
};
