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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique()->index();
            $table->string('emp_id')->unique()->index();
            $table->string('department')->nullable();
            $table->string('title')->nullable();
            $table->text('research_interests')->nullable();
            $table->string('office_location')->nullable();
            $table->integer('max_students')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};
