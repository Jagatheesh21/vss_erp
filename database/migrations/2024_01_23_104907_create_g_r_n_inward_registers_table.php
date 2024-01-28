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
        Schema::create('g_r_n_inward_registers', function (Blueprint $table) {
            $table->id();
            $table->string('grnnumber')->unique();
            $table->date('grndate');
            $table->integer('po_id');
            $table->integer('p_o_product_id');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('dc_number')->nullable();
            $table->date('dc_date')->nullable();
            $table->string('pad_number')->nullable();
            $table->string('release_number')->nullable();
            $table->float('inward_qty', 8, 2)->default(0);
            $table->float('issued_qty', 8, 2)->default(0);
            $table->float('return_dc_qty', 8, 2)->default(0);
            $table->date('grn_close_date')->nullable();
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
        Schema::dropIfExists('g_r_n_inward_registers');
    }
};
