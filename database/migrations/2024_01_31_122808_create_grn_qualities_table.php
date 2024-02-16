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
        Schema::create('grn_qualities', function (Blueprint $table) {
            $table->id();
            $table->integer('grnnumber_id');
            $table->integer('rack_id');
            $table->integer('heat_no_id');
            $table->integer('inspected_by')->nullable();
            $table->date('inspected_date')->nullable();
            $table->float('inspected_qty', 8, 2)->default(0);
            $table->float('approved_qty', 8, 2)->default(0);
            $table->float('onhold_qty', 8, 2)->default(0);
            $table->float('rejected_qty', 8, 2)->default(0);
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
        Schema::dropIfExists('grn_qualities');
    }
};
