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
        Schema::create('bom_masters', function (Blueprint $table) {
            $table->id();
            // child_part_id means manufacturing parts
            $table->integer('child_part_id');
            $table->integer('rm_id');
            $table->integer('uom_id');
            $table->float('input_usage', 10,7)->default(0);
            $table->float('output_usage', 10,7)->default(0);
            $table->integer('status')->default(1);
            $table->string('foreman');
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
        Schema::dropIfExists('bom_masters');
    }
};
