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
        Schema::create('final_qc_inspections', function (Blueprint $table) {
            $table->id();
            $table->date('offer_date');
            $table->integer('rc_id');
            $table->integer('previous_rc_id');
            $table->integer('part_id');
            $table->integer('process_id');
            $table->integer('product_process_id');
            $table->integer('next_process_id');
            $table->integer('next_product_process_id');
            $table->float('offer_qty', 8, 2)->default(0);
            $table->float('inspect_qty', 8, 2)->default(0);
            $table->float('approve_qty', 8, 2)->default(0);
            $table->float('reject_qty', 8, 2)->default(0);
            $table->float('rework_qty', 8, 2)->default(0);
            $table->integer('inspect_by')->nullable();
            $table->timestamp('inspect_date')->useCurrentOnUpdate();
            $table->integer('rc_status')->default(0);
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
        Schema::dropIfExists('final_qc_inspections');
    }
};
