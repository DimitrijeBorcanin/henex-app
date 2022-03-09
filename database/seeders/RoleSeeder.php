<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private $roles = ["Admin", "Kontrolor", "Tehničar"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->roles as $r){
            Role::create(["name" => $r]);
        }
    }
}
