<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    private $types = ["DOPRINOSI", "NETO PLATA 1", "PREVOZ", "AGENCIJA DUG", "ZAKUP 1", "ZAKUP 2 KEŠ", "NETO PLAT 2 KEŠ", "PDV", "BOLOBANJE", "DOPUNSKI RAD", "KNJIGOVODJA", "FRANŠIZA", "AGENCIJA PROVIZIJA TP", "AGENCIJA PROVIZIJA POLISE", "PROVIZIJA BANKE", "ABS", "RATA KREDIT", "PRIMLJENA POZAJMICA", "PRIMLJEN AVANS", "POREZ NA DOBIT", "REGOS", "KANCELARIJSKI", "REKLAMNI", "STRUJA", "VODA", "VODA (APARAT)", "INFOSTAN", "INTERNET", "GPRS", "MOBILNI TEL.", "FIXNI TEL.", "FISKALNA GOTOVINA", "FISKALNA BEZGOTOVINA", "POLICOM SMS", "TROŠAK POS TERMINALA", "ODRŽAVANJE-FISKALNA KASA", "JKP GRADSKA ČISTOĆA", "PIO OSNIVAČA", "PID ODLOŽENI", "KASKO GENERALI", "ZDRAVSTVENO GENERALI", "BOX PAKET", "SPREMAČICA", "SWING", "GORIVO", "BZR", "PPZ", "TAKSE MUP-U", "SUVIŠAK PAYSPOT", "PTT TROŠKOVI", "ŽETONI ZA KAFU", "WEBINAR", "KNJIGA DUŽNIKA", "DUŽNIK RATA", "PKS/APR", "VAUČER GENERALI", "VAUČER BEOGUMA", "MANJAK", "BAŽDARENJE OPREME", "IZLAZ FINANSIJE", "UZETO IZ DEPOZITA", "GRATIS AN"];
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
