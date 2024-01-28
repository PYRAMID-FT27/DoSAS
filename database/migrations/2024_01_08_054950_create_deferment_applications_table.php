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
        Schema::create('deferment_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->string('status',['rejected','approved','reviewing','process','draft','pending'])->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->string('semester')->nullable();
            $table->enum('type',['academic','personal','medical','other'])->nullable();
            $table->text('details')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deferment_applications');
    }
};
