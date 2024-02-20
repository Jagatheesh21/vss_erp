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
        Schema::create('customer_product_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('cus_id');
            $table->integer('part_id');
            $table->integer('part_type');
            $table->string('part_hsnc');
            $table->string('cus_po_number');
            $table->date('cus_po_date');
            $table->integer('cus_po_qty')->default(0);
            $table->integer('cus_revise_qty')->default(0);
            $table->date('cus_po_target_date')->nullable();
            $table->date('cus_po_revise_target_date')->nullable();
            $table->float('packing_charges', 8, 2)->default(0);
            $table->string('trans_mode');
            $table->integer('currency_id');
            $table->float('part_rate', 8, 2)->default(0);
            $table->integer('part_per')->default(1);
            $table->integer('uom_id')->default(1);
            $table->float('cgst', 8, 2)->default(0);
            $table->float('sgst', 8, 2)->default(0);
            $table->float('igst', 8, 2)->default(0);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('customer_product_masters');
    }
};
