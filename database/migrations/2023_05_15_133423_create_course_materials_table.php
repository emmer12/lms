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
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id');
            $table->enum('content_type', ['doc', 'video', 'audio']);
            $table->integer('video_duration')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('video_storage', ['s3', 'local'])->nullable();
            $table->enum('video_src', ['upload', 'embed'])->nullable();
            $table->integer('audio_duration')->nullable();
            $table->string('audio_path')->nullable();
            $table->enum('audio_storage', ['s3', 'local'])->nullable();
            $table->enum('audio_src', ['upload', 'embed'])->nullable();
            $table->string('doc_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_materials');
    }
};
