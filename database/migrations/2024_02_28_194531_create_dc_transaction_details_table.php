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
        Schema::create('dc_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('dc_master_id');
            $table->date('issue_date');
            $table->float('issue_qty', 8, 2)->default(0);
            $table->float('receive_qty', 8, 2)->default(0);
            $table->float('unit_rate', 8, 2)->default(0);
            $table->float('total_rate', 8, 2)->default(0);
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('dc_transaction_details');
    }
};