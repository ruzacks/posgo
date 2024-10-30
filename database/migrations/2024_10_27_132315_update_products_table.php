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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('vendor_id')->default('0');
            $table->boolean('is_stock')->default('0');
            $table->integer('min_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->boolean('is_consigment')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
            $table->dropColumn('is_stock');
            $table->dropColumn('min_stock');
            $table->dropColumn('max_stock');
            $table->dropColumn('is_consigment');
        });
    }
};
