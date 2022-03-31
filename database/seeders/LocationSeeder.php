<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    private $locations = ["Dušanovac", "Novi Beograd", "Borča", "Umka", "Zemun", "Kaluđerica", "Kumodraž", "Mirijevo", "Rakovica", "Leštane", "Mali Mokri Lug", "Altina", "Mladenovac", "Obrenovac", "Bezar", "Urovci", "Čukarica"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->locations as $l){
            Location::create(["name" => $l]);
        }
    }
}
