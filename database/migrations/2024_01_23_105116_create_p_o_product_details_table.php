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
        Schema::create('p_o_product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('po_id');
            $table->integer('supplier_id');
            $table->integer('supplier_product_id');
            $table->date('duedate')->nullable();
            $table->integer('qty');
            $table->float('rate', 8, 2);
            $table->date('po_close_date')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('p_o_product_details');
    }
};
