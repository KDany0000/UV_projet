<?php

namespace Database\Seeders;

use App\Models\TblFiliere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblFiliere::create([
            'nom_fil'=>'Informatique',
            'tbl_faculte_id'=>'1',
        ]);

        TblFiliere::create([
            'nom_fil'=>'Mathematique',
            'tbl_faculte_id'=>'1',
        ]);
    }
}
