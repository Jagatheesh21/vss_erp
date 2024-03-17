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
            $table->integer('rc_id')->unique();
            $table->date('issue_date');
            $table->integer('dc_master_id');
            $table->integer('type')->default(1);
            $table->integer('uom_id')->default(2);
            $table->float('issue_qty', 8, 2)->default(0);
            $table->float('receive_qty', 8, 2)->default(0);
            $table->float('unit_rate', 8, 2)->default(0);
            $table->float('basic_rate', 8, 2)->default(0);
            $table->float('total_rate', 8, 2)->default(0);
            $table->float('issue_wt', 8, 2)->default(0);
            $table->float('receive_wt', 8, 2)->default(0);
            $table->integer('no_cover')->default(0);
            $table->integer('cover_qty')->default(0);
            $table->string('reason')->nullable();
            $table->string('remarks')->nullable();
            $table->string('trans_mode');
            $table->string('vehicle_no');
            $table->integer('from_unit')->default(1);
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
        Schema::dropIfExists('dc_transaction_details');
    }
};
