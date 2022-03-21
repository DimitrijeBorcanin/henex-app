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
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => "$2a$12\$JK.TsmJavJIk7iWh0wMRjOXL6l8coIpSafWpjEk.uGT7yilD0sm5e",
            "role_id" => 1
        ]);

        // \App\Models\User::factory(50)->create();
    }
}
