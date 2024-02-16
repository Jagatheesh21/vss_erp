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
        Schema::create('heat_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('heatnumber');
            $table->integer('grnnumber_id');
            $table->integer('rack_id');
            $table->string('tc_no')->default(0);
            $table->integer('coil_no')->default(0);
            $table->integer('lot_no')->default(0);
            $table->float('coil_inward_qty', 8, 2)->default(0);
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
        Schema::dropIfExists('heat_numbers');
    }
};
