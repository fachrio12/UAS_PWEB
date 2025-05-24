<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_assessment_sessions');
            $table->string('result_category', 100);
            $table->integer('score');
            $table->text('interpretation')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assessment_results');
    }
};
