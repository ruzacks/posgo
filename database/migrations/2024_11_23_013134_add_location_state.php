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
        Schema::table('locations', function (Blueprint $table) {
            $table->string('state')->nullable()->comment('State of the location process');
            $table->string('processing_by')->nullable()->comment('User processing the location');
            $table->datetime('last_process_call')->nullable()->comment('Last time the process was called');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('processing_by');
            $table->dropColumn('last_process_call');
        });
    }
};
