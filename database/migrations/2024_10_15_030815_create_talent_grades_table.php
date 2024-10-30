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
        Schema::create('talent_grades', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Beginner', 'Expert', etc.
            $table->float('talent_price')->nullable();
            $table->float('office_price')->nullable();
            $table->float('agency_price')->nullable();
            $table->integer('created_by')->default('0');
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
        Schema::dropIfExists('talent_grades');
    }
};
