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
                'password_hash' => bcrypt('admin123'),
                'email' => 'admin@campora.com',
            ]
        );
    }
}
