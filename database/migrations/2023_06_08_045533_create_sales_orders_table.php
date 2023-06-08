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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->date('so_date');
            $table->string('faktur', '20');
            $table->string('cashier_code', '5');
            $table->string('cashier_name', '150');
            $table->decimal('total', 12, 2);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->decimal('kembali', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
