<?php

namespace Database\Seeders;

use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class InsuranceCompanySeeder extends Seeder
{
    private $companies = ["Generali", "Dunav", "Sava", "Grawe", "DDOR"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->companies as $c){
            InsuranceCompany::create(["name" => $c]);
        }
    }
}
