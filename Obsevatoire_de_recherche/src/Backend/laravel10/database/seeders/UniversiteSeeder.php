<?php

namespace Database\Seeders;

use App\Models\TblUniversite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblUniversite::create([
            'nom_univ' =>'Universite de Dschang',
            'email_univ'=>'uds@gmail.com',
            'localite_univ'=> 'Ouest',
            'boite_postale'=> 'BP140',
        ]);
    }
}
