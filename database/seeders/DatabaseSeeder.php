<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'jdc@test.com',
            'email_verified_at' => null,
        ]);

        Task::factory()->times(15)->create();
    }
}
