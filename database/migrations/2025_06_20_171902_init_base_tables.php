<?php

use App\Support\Enums\AthleteLevel;
use App\Support\Enums\Gender;
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
            $table->ulid('id')->primary();

            $table->string('title');
            $table->string('description')->nullable();
            $table->json('attrs')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->nullable();

            $table->string('name');
            $table->enum('gender', Gender::toArray())->nullable();
            $table->unsignedBigInteger('level')->comment(
                sprintf('See %s for detail', AthleteLevel::class)
            );

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignUlid('participant_id')->constrained('people')->cascadeOnDelete();

            $table->string('number', 20);
            $table->unsignedBigInteger('level')->comment(
                sprintf('See %s for detail', AthleteLevel::class)
            );
            $table->json('attrs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participations');
        Schema::dropIfExists('people');
        Schema::dropIfExists('events');
    }
};
