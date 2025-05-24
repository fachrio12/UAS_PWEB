<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_assessment_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->timestamp('taken_at')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_assessment_sessions');
    }
};
