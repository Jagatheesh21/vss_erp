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
        Schema::create('invoice_correction_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->integer('cus_product_id');
            $table->string('part_hsnc');
            $table->integer('cus_po_id');
            $table->integer('qty')->default(0);
            $table->integer('uom_id')->default(2);
            $table->integer('part_per')->default(1);
            $table->integer('rate')->default(1);
            $table->integer('currency_id');
            $table->float('packing_charge', 8, 2)->default(0);
            $table->float('part_rate', 8, 2)->default(0);
            $table->float('cgst', 8, 2)->default(0);
            $table->float('sgst', 8, 2)->default(0);
            $table->float('igst', 8, 2)->default(0);
            $table->float('basic_value', 8, 2)->default(0);
            $table->float('packing_charge_amt', 8, 2)->default(0);
            $table->float('cigstamt', 8, 2)->default(0);
            $table->float('sgstamt', 8, 2)->default(0);
            $table->float('total_basic_value', 8, 2)->default(0);
            $table->float('total_cigstamt', 8, 2)->default(0);
            $table->float('total_sigstamt', 8, 2)->default(0);
            $table->float('invtotal', 8, 2)->default(0);
            $table->string('inwords')->nullable();
            $table->string('inwords1')->nullable();
            $table->string('cori')->nullable();
            $table->string('trans_mode');
            $table->string('vehicle_no')->nullable();
            $table->string('sup')->nullable();
            $table->string('ok')->nullable();
            $table->string('type')->nullable();
            $table->string('tcs')->nullable();
            $table->text('remarks')->nullable();
            $table->text('remarks1')->nullable();
            $table->text('remarks2')->nullable();
            $table->text('remarks3')->nullable();
            $table->text('remarks4')->nullable();
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
        Schema::dropIfExists('invoice_correction_details');
    }
};
