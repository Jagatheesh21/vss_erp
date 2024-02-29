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
        Schema::create('part_rejection_histories', function (Blueprint $table) {
            $table->id();
            $table->date('offer_date');
            $table->integer('rc_id');
            $table->integer('previous_rc_id');
            $table->integer('part_id');
            $table->integer('process_id');
            $table->integer('product_process_id');
            $table->integer('next_process_id');
            $table->integer('next_product_process_id');
            $table->float('inspect_qty', 8, 2)->default(0);
            $table->float('reject_qty', 8, 2)->default(0);
            $table->string('type')->nullable();
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
        Schema::dropIfExists('part_rejection_histories');
    }
};
