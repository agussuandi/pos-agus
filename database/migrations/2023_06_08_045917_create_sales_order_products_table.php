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
        Schema::create('sales_order_products', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_order_id');
            $table->string('product_code', 5);
            $table->string('product_name', 200);
            $table->decimal('product_price', 12, 2);
            $table->integer('qty');
            $table->timestamps();

            $table->index('sales_order_id');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_products');
    }
};
