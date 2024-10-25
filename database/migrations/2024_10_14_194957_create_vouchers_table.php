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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();  // Primary key (Auto Increment)
            $table->string('voucher_code', 50)->unique();  // Voucher code
            $table->enum('discount_type', ['fixed', 'percentage']);  // Discount type
            $table->decimal('discount_value', 10, 2);  // Discount value
            $table->decimal('max_discount', 10, 2)->nullable();  // Optional: max discount for percentage type
            $table->date('start_date');  // Start date
            $table->date('expiry_date');  // Expiry date
            $table->integer('usage_limit')->nullable();  // Optional: usage limit
            $table->boolean('is_active')->default(true);  // Active status (true or false)
            $table->integer('created_by')->default('0');
            $table->timestamps();  // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
