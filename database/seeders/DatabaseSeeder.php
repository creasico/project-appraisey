<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createAdminUser();
    }

    private function createAdminUser(): void
    {
        if (User::count() > 0) {
            return;
        }

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);
    }
}
