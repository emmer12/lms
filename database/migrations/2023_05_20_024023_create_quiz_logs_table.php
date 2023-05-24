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
        Schema::create('quiz_logs', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_week');
            $table->foreignId('user_id');
            $table->foreignId('quiz_id');
            $table->enum('mode', ['test', 'exam'])->default('test');
            $table->mediumText('questions');
            $table->mediumText('answers');
            $table->integer('total_questions')->default(0);
            $table->integer('num_attempted')->default(0);
            $table->integer('num_correct')->default(0);
            $table->integer('score')->default(0);
            $table->integer('total_duration')->default(0);
            $table->integer('time_spent')->default(0);
            $table->integer('exam_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_logs');
    }
};
