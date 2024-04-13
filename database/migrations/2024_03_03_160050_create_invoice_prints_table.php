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
        Schema::create('invoice_prints', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no');
            $table->integer('popt')->default(1);
            $table->string('pname')->default('LPT3');
            $table->string('fip')->default('LPT2');
            $table->integer('print_status')->default(0);
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
        Schema::dropIfExists('invoice_prints');
    }
};
