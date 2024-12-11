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
        Schema::create('selled_package_talent', function (Blueprint $table) {
            $table->id();
            $table->integer('selled_item_id');
            $table->integer('talent_id');
            $table->integer('hour');
            $table->double('talent_price',15,2);
            $table->double('agency_price',15,2);
            $table->double('office_price',15,2);
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
        Schema::dropIfExists('selled_package_talent');
    }
};
