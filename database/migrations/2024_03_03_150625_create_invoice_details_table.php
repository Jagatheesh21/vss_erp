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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no')->unique();
            $table->date('invoice_date');
            $table->time('invoice_time');
            $table->integer('cus_product_id');
            $table->integer('part_id');
            $table->string('part_hsnc');
            $table->integer('cus_po_id');
            $table->integer('qty')->default(0);
            $table->integer('uom_id')->default(2);
            $table->integer('part_per')->default(1);
            $table->integer('currency_id');
            $table->float('packing_charge', 8, 2)->default(0);
            $table->float('part_rate', 8, 2)->default(0);
            $table->float('cgst', 8, 2)->default(0);
            $table->float('sgst', 8, 2)->default(0);
            $table->float('igst', 8, 2)->default(0);
            $table->float('tcs', 8, 2)->default(0);
            $table->float('basic_value', 8, 2)->default(0);
            $table->float('packing_charge_amt', 8, 2)->default(0);
            $table->float('cgstamt', 8, 2)->default(0);
            $table->float('sgstamt', 8, 2)->default(0);
            $table->float('igstamt', 8, 2)->default(0);
            $table->float('tcsamt', 8, 2)->default(0);
            $table->float('invtotal', 8, 2)->default(0);
            $table->string('cori')->nullable();
            $table->string('trans_mode');
            $table->string('vehicle_no')->nullable();
            $table->integer('sup')->default(0);
            $table->string('ok')->nullable();
            $table->integer('type')->default(2);
            $table->string('document_type')->nullable();
            $table->string('reverse_charge')->nullable();
            $table->string('igst_on_intra')->nullable();
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
        Schema::dropIfExists('invoice_details');
    }
};
