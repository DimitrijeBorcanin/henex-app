<?php

namespace Database\Seeders;

use App\Models\IncomeType;
use Illuminate\Database\Seeder;

class IncomeTypeSeeder extends Seeder
{
    private $specials = [
        ["id" => 1, "name" => "OSTALO"],
        ["id" => 2, "name" => "DEPOZIT"],
        ["id" => 3, "name" => "UPLATA PAZARA"]
    ];

    private $types = ["PRIMLJENA POZAJMICA", "ZELENI KARTON", "PRIMLJEN AVANS", "UZETO IZ SEFA", "UPLATE FIZ. LICA RAČUNI", "PRIHOD OD TP", "PRIHOD FAKTURE PRAVNA L.", "RATA DUŽNIKA", "PROVIZIJA PAYSPOT", "AGENCIJA POVRAT DUGA", "GRAWE", "SAVA", "GENERALI", "DUNAV"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->specials as $s){
            IncomeType::create($s);
        }

        foreach($this->types as $t){
            IncomeType::create(["name" => $t]);
        }
    }
}
