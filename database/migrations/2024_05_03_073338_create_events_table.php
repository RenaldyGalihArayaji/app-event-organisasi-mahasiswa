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

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('event_name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('event_price', 15, 2);
            $table->string('event_image');
            $table->enum('method_type', ['free', 'paid'])->default('free');
            $table->enum('activity', ['online', 'offline'])->default('offline');
            $table->text('event_description');
            $table->string('event_venue');
            $table->string('event_speaker')->nullable();
            $table->unsignedInteger('participant_quota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
