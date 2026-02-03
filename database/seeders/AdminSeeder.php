<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@octopass.local',
            'password' => Hash::make('Admin@12345'),
            'role' => 'super_admin',
        ]);

        echo "\n✅ Admin created:\n";
        echo "   Email: admin@octopass.local\n";
        echo "   Password: Admin@12345\n\n";
    }
}
