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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique()->comment('Employee ID');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->foreignId('position_id')->constrained('worker_positions')->onDelete('restrict');
            $table->foreignId('category_id')->constrained('worker_categories')->onDelete('restrict');
            $table->date('hire_date');
            $table->enum('status', ['Active', 'On-Leave', 'Transferred', 'Terminated'])->default('Active');
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
