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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('img')->nullable();
            $table->unsignedBigInteger('course_category_id'); 
            $table->longText('gdrive_link');
            $table->longText('gdrive_sample_link')->nullable();
            $table->boolean('is_free')->default(false);
            $table->decimal('price', 8, 2); 
            $table->timestamps();
        
            $table->foreign('course_category_id')->references('id')->on('course_categories')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
