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
        Schema::create('customer_masters', function (Blueprint $table) {
            $table->id();
            $table->string('cus_code')->unique();
            $table->string('cus_type')->default(1);
            $table->string('cus_name');
            $table->string('cus_gst_number');
            $table->text('cus_address');
            $table->text('cus_address1')->nullable();
            $table->text('cus_city');
            $table->text('cus_state');
            $table->text('cus_country');
            $table->text('cus_pincode');
            $table->string('delivery_cus_name');
            $table->string('delivery_cus_gst_number');
            $table->text('delivery_cus_address');
            $table->text('delivery_cus_address1')->nullable();
            $table->text('delivery_cus_city');
            $table->text('delivery_cus_state');
            $table->text('delivery_cus_country');
            $table->text('delivery_cus_pincode');
            $table->string('supplier_vendor_code');
            $table->string('supplytype');
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
        Schema::dropIfExists('customer_masters');
    }
};
