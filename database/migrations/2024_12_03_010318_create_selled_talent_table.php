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
        Schema::create('selled_talent', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->integer('talent_id');
            $table->float('talent_price');
            $table->float('agency_price');
            $table->float('office_price');
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
        Schema::dropIfExists('selled_talent');
    }
};
