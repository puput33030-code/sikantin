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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('email', 128);
            $table->enum('order_type', ['diambil','diantar'])->default('diambil');
            $table->string('delivery_address', 64)->nullable();
            $table->longText('notes')->nullable();
            $table->decimal('total_price', 10, 2)->unsigned()->default(0);
            $table->enum('status', ['diproses', 'siap', 'selesai'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
