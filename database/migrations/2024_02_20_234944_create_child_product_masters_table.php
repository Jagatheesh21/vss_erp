<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_product_masters', function (Blueprint $table) {
            $table->id();
            $table->string('stocking_point');
            $table->string('child_part_no');
            $table->integer('part_id');
            $table->integer('pickup_part_id');
            $table->integer('product_type')->default(1);
            $table->integer('machine_id')->default(1);
            $table->integer('foreman_id')->default(1);
            $table->integer('item_type')->default(1);
            $table->integer('no_item_id')->default(1);
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
        Schema::dropIfExists('child_product_masters');
    }
};
