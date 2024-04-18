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
        Schema::create('invoice_correction_masters', function (Blueprint $table) {
            $table->id();
            $table->date('correction_request_date');
            $table->string('invoice_id');
            $table->integer('qty')->default(0);
            $table->text('request_reason');
            $table->integer('approved_by');
            $table->date('approved_date');
            $table->text('approved_reason')->nullable();
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
        Schema::dropIfExists('invoice_correction_masters');
    }
};
