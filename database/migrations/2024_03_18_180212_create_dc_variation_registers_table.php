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
        Schema::create('dc_variation_registers', function (Blueprint $table) {
            $table->id();
            $table->date('receive_date')->nullable();
            $table->integer('previous_dc_id');
            $table->integer('from_unit')->default(1);
            $table->float('issue_qty', 8, 2)->default(0);
            $table->float('receive_qty', 8, 2)->default(0);
            $table->float('balance', 8, 2)->default(0);
            $table->string('rejected_reason')->nullable();
            $table->string('correction_reason')->nullable();
            $table->date('target_date')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('rc_status')->default(1);
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
        Schema::dropIfExists('dc_variation_registers');
    }
};
