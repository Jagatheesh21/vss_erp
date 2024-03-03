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
        Schema::create('customer_po_rate_revises', function (Blueprint $table) {
            $table->id();
            $table->integer('cus_id');
            $table->integer('part_id');
            $table->integer('cus_po_id');
            $table->integer('cus_po_qty')->default(0);
            $table->integer('uom_id')->default(2);
            $table->integer('part_per')->default(1);
            $table->integer('status')->default(1);
            $table->integer('prepared_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_po_rate_revises');
    }
};
