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
        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('deferment_applications')->onDelete('cascade');
            $table->foreignId('changed_by')->constrained('users')->onDelete('set null');
            $table->dateTime('changed_at');
            $table->enum('previous_status',['rejected','approved','reviewing','process','draft','pending']);
            $table->string('new_status',['rejected','approved','reviewing','process','draft','pending']);
            $table->text('remarks')->nullable();
            $table->string('action_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_logs');
    }
};
