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
        Schema::create('material_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->enum('type', ['addition','usage','adjustment','damage','return'])->default('addition');
            $table->integer('quantity');
            $table->string('reference_type')->nullable()->comment('material_request, purchase_order, damage_report, etc');
            $table->integer('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable(); // nullable for ON DELETE SET NULL
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks to prevent errors when dropping the table
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('material_transactions');
        Schema::enableForeignKeyConstraints();
    }
};
