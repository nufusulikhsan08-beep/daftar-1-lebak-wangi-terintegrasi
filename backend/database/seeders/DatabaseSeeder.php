<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Dinas Pendidikan',
            'email' => 'admin@lebakwangi.sch.id',
            'password' => Hash::make('admin123456'), // Change this in production!
            'role' => 'admin_dinas',
            'is_active' => true,
        ]);
        
        // Run other seeders
        $this->call([
            SchoolSeeder::class,
        ]);
    }
}