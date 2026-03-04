<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrations for the anonymous surveys system (Part 1 of the technical test).
 *
 * Schema:
 *   surveys       ─┐
 *   questions     ─┤ (survey_id FK)
 *   options       ─┤ (question_id FK)
 *   responses     ─┤ (survey_id FK, anonymous_token UUID)
 *   answers        └ (response_id FK, question_id FK, option_id FK nullable)
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── surveys ──────────────────────────────────────────────────────────
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        // ── questions ─────────────────────────────────────────────────────────
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['single', 'multiple', 'text'])->default('single');
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });

        // ── options ───────────────────────────────────────────────────────────
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->string('option_text', 255);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        // ── responses ─────────────────────────────────────────────────────────
        // No FK to users: fully anonymous via UUID token.
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->uuid('anonymous_token')->unique();   // one token per submission
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
        });

        // ── answers ───────────────────────────────────────────────────────────
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('set null');
            $table->text('answer_text')->nullable(); // for type=text
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
        Schema::dropIfExists('responses');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('surveys');
    }
};
