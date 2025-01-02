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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->boolean('verified')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 8, 2); // Total payment amount
            $table->string('reference_number')->unique()->nullable(); // External payment gateway transaction ID
            $table->timestamp('payment_date')->nullable();
            $table->string('gcash_screenshot')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
