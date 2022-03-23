<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    private $types = ["Ostalo", "Neto plata", "Zakup", "Prevoz"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->types as $t){
            ExpenseType::create(["name" => $t]);
        }
    }
}
