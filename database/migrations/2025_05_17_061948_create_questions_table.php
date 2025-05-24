<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->text('question_text');
            $table->enum('question_type', ['pilihan_ganda', 'skala_likert', 'gambar', 'drag_drop']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('questions');
    }
};
