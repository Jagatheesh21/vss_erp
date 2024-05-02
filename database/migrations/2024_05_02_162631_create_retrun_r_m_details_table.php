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
        Schema::create('retrun_r_m_details', function (Blueprint $table) {
            $table->id();
            $table->date('open_date');
            $table->integer('process_id');
            $table->integer('part_id');
            $table->integer('rc_id');
            $table->integer('grn_id');
            $table->integer('rm_id');
            $table->integer('heat_no_id');
            $table->float('avl_qty', 8, 2)->default(0);
            $table->float('return_qty', 8, 2)->default(0);
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('retrun_r_m_details');
    }
};
