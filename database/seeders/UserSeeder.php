<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'User Name 1',
            'email' => 'user1@tomosia.com',
            'password' => Hash::make('12345678@')
        ]);

        DB::table('users')->insert([
            'name' => 'User Name 2',
            'email' => 'user2@tomosia.com',
            'password' => Hash::make('12345678@')
        ]);

        DB::table('users')->insert([
            'name' => 'User Name 3',
            'email' => 'user3@tomosia.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
