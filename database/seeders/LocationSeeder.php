<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    private $locations = ["Kumodraž", "Zemun", "Novi Beograd"];
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
