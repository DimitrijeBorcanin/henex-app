<?php

namespace Database\Seeders;

use App\Models\IncomeType;
use Illuminate\Database\Seeder;

class IncomeTypeSeeder extends Seeder
{
    private $types = ["Ostalo", "Komunalni troškovi", "Zeleni karton"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->types as $t){
            IncomeType::create(["name" => $t]);
        }
    }
}
