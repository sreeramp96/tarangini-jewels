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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('total_amount');
            $table->decimal('taxes', 10, 2)->after('subtotal');
            $table->decimal('shipping_cost', 10, 2)->after('taxes');
            $table->string('shipping_first_name')->after('shipping_cost');
            $table->string('shipping_last_name')->after('shipping_first_name');
            $table->string('shipping_phone')->after('shipping_last_name');
            $table->string('shipping_address')->after('shipping_phone');
            $table->string('shipping_city')->after('shipping_address');
            $table->string('shipping_state')->after('shipping_city');
            $table->string('shipping_zipcode')->after('shipping_state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {});
    }
};
