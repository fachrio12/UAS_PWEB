<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motivation_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_assessment_sessions');
            $table->string('factor_name', 100);
            $table->integer('score');
        });
    }

    public function down(): void {
        Schema::dropIfExists('motivation_factors');
    }
};
