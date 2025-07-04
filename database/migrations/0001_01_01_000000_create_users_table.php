<?php

declare(strict_types=1);

use App\Support\Enums\UserRole;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedTinyInteger('role')->comment(
                sprintf('See %s for detail', UserRole::class)
            );
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        if ($session = $this->databaseSession()) {
            Schema::connection($session['connection'])->create(
                $session['table'],
                function (Blueprint $table) {
                    $table->string('id')->primary();
                    $table->foreignId('user_id')->nullable()->index();
                    $table->string('ip_address', 45)->nullable();
                    $table->text('user_agent')->nullable();
                    $table->longText('payload');
                    $table->integer('last_activity')->index();

                    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');

        if ($session = $this->databaseSession()) {
            Schema::connection($session['connection'])->dropIfExists($session['table']);
        }
    }

    private function databaseSession(): ?array
    {
        $config = config('session');

        return $config['driver'] === 'database' ? $config : null;
    }
};
