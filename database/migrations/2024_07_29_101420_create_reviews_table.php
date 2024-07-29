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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('aplications')->onUpdate('cascade')->onDelete('restrict');
            $table->string('user_name');
            $table->integer('rating');
            $table->text('review_text');
            $table->enum('sentiment', ['positive', 'neutral', 'negative']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
