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
        Schema::create('trans_data_d11_s', function (Blueprint $table) {
            $table->id();
            $table->date('open_date');
            $table->string('rc_no')->unique();
            $table->integer('part_id');
            $table->integer('product_process_id');
            $table->string('process_name');
            $table->string('next_process_name');
            $table->float('process_issue_qty', 8, 2)->default(0);
            $table->float('receive_qty', 8, 2)->default(0);
            $table->float('reject_qty', 8, 2)->default(0);
            $table->float('rework_qty', 8, 2)->default(0);
            $table->float('issue_qty', 8, 2)->default(0);
            $table->date('close_date')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('trans_data_d11_s');
    }
};
