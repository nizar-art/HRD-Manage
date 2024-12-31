<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin1@mail.com'], // Kondisi untuk menghindari duplikasi
            [
                'first_name' => 'Admin',
                'last_name' => '1',
                'email_verified_at' => now(),
                'role' => 'superadmin',
                'password' => Hash::make('admin123'),
                'phone_number' => '+6285217861296',
                'address' => 'Perum Karaba Indah Blok D No. 24',
                'province' => 'Jawa Barat',
                'country' => 'Indonesia',
                'zip_code' => '41361',
                'avatar' => 'assets/img/avatars/1.png',
                'is_active' => true,
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
