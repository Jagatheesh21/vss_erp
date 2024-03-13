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
        Schema::create('product_process_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('part_id');
            $table->integer('process_master_id');
            $table->integer('process_order_id')->default(0);
            $table->float('cycle_time', 8, 2)->default(0);
            $table->float('setting_time', 8, 2)->default(0);
            $table->integer('foreman_id')->default(1);
            $table->integer('machine_id')->default(1);
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
        Schema::dropIfExists('product_process_masters');
    }
};
