<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'                  => 'Superadmin',
            'username'              => 'superadmin',
            'email'                 => 'superadmin@gmail.com',
            'password'              => bcrypt('superadmin'),
            'email_verified_at'     => now(),
            'is_active'             => true,
            'login_failed_count'    => 0,
            'status'                => true,
        ]);
    }
}
