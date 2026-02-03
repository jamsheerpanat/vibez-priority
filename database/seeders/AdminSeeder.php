<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'jamsheerpanat@gmail.com'],
            [
                'name' => 'Jamsheer Panat',
                'password' => Hash::make('99754133'),
                'role' => 'super_admin',
            ]
        );

        echo "\n✅ Admin Updated/Created:\n";
        echo "   Email: jamsheerpanat@gmail.com\n";
        echo "   Password: [as provided]\n\n";
    }
}
