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
        Schema::create('dc_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('part_id')->default(0);
            $table->integer('rm_id')->default(0);
            $table->integer('type_id')->default(1);
            $table->integer('operation_id');
            $table->string('operation_desc');
            $table->string('hsnc');
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
        Schema::dropIfExists('dc_masters');
    }
};
