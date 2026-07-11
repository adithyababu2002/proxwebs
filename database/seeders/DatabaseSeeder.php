<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First-time only: never overwrite an existing admin password/name on re-seed.
        User::query()->firstOrCreate(
            ['email' => 'admin@proxwebs.com'],
            [
                'name' => 'Proxwebs Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->call(TeamMemberSeeder::class);
    }
}
