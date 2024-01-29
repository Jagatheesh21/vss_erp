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
        Schema::create('p_o_details', function (Blueprint $table) {
            $table->id();
            $table->string('ponumber')->unique();
            $table->date('podate');
            $table->string('purchasetype');
            $table->string('payment_terms');
            $table->integer('supplier_id');
            $table->string('indentno')->nullable();
            $table->date('indentdate')->nullable();
            $table->string('quotno')->nullable();
            $table->date('quotdt')->nullable();
            $table->text('remarks1')->nullable();
            $table->text('remarks2')->nullable();
            $table->text('remarks3')->nullable();
            $table->text('remarks4')->nullable();
            $table->date('po_close_date')->nullable();
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
        Schema::dropIfExists('p_o_details');
    }
};
