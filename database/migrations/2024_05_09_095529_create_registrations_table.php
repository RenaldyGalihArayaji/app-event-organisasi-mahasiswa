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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('code_registration');
            $table->string('name');
            $table->string('nim');
            $table->string('prodi');
            $table->string('email');
            $table->string('phone');
            $table->string('proof_payment')->nullable();
            $table->enum('attendance_status', ['present', 'absent'])->default('absent');
            $table->enum('email_status', ['waiting', 'approve'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
