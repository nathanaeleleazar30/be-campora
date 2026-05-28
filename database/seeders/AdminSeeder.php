<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'password_hash' => bcrypt('Admin123_'),
                'email' => 'admin@campora.com', 
            ]
        );
    }
}
