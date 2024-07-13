<?php

namespace Database\Seeders;

use App\Models\TblNiveau;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblNiveau::create([
            'code_niv'=> 'Informatique 1',
        ]);

        TblNiveau::create([
            'code_niv'=> 'Informatique 2',
        ]);

        TblNiveau::create([
            'code_niv'=> 'Informatique 3',
        ]);
        
        TblNiveau::create([
            'code_niv'=> 'Informatique 4',
        ]);

        TblNiveau::create([
            'code_niv'=> 'informatique 5',
        ]);
        

        TblNiveau::create([
            'code_niv'=> 'Mathematique 1',
        ]);

        TblNiveau::create([
            'code_niv'=> 'Mathematique 2',
        ]);

        TblNiveau::create([
            'code_niv'=> 'Mathematique 3',
        ]);
        
        TblNiveau::create([
            'code_niv'=> 'Mathematique 4',
        ]);

        TblNiveau::create([
            'code_niv'=> 'Mathematique 5',
        ]);
        

        TblNiveau::create([
            'code_niv'=> 'Doctorat Math',
        ]);
        
        TblNiveau::create([
            'code_niv'=> 'Doctorat Inf',
        ]);



    }
}
