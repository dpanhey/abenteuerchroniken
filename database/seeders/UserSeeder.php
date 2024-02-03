<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->create();

        DB::table('users')->insert([
            'name' => 'Dustin',
            'email' => 'd.panhey@gmx.de',
            'password' => Hash::make('Saufnase'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
