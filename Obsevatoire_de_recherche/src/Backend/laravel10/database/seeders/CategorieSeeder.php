<?php

namespace Database\Seeders;

use App\Models\TblCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblCategorie::create([
            'nom_cat'=>'article',
            'descript_cat'=>'gestion des articles de chercheurs',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Memoire',
            'descript_cat'=>'gestion des Memoires de chercheurs',
        ]);

        TblCategorie::create([
            'nom_cat'=>'projets',
            'descript_cat'=>'gestion des projets de chercheurs',
        ]);

        TblCategorie::create([
            'nom_cat'=>'projets de cycle 1',
            'descript_cat'=>'gestion des projets de cycle  1 de chercheurs',
        ]);

        TblCategorie::create([
            'nom_cat'=>'projets de cycle 2',
            'descript_cat'=>'gestion des projets de cycle  1 de chercheurs',
        ]);
    }
}
