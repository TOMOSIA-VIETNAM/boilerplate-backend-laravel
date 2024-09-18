<?php

namespace Database\Seeders;

use App\Containers\Admin\Models\Admin;
use App\Containers\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
        User::factory(10)->create();
        Admin::factory(1)->create();
    }
}
