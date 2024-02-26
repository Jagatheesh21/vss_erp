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
        Schema::create('grn_rejections', function (Blueprint $table) {
            $table->id();
            $table->integer('grnnumber_id');
            $table->integer('heat_no_id');
            $table->integer('grnqc_id');
            $table->string('reason');
            $table->integer('supplier_status')->default(0);
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
        Schema::dropIfExists('grn_rejections');
    }
};
