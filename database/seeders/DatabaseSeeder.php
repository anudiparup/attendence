<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'user_id' => 'AF0123FG',
            'email' => 'test@example.com',
            'mobile_no'=>'9878767654',
            'password' => bcrypt(AF0123FG),
            
        ]);
    }
}
