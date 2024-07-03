<?php

namespace Database\Seeders;

use App\Models\TblProjet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       TblProjet::create([
            'titre_projet'=>'Gestion De Projets D etudiant',
            'descript_projet' => 'ce projet vise a donner un moyen aux etudiants de l universiter de Dschang de pouvoir soumettre leurs projet dans une plateforme dedie a cela',
            'user_id'=>'1',
            'tbl_niveau_id'=>'1',
            'tbl_categorie_id'=>'1',
        ]);

        TblProjet::create([
            'titre_projet'=>'Gestion De Restaurant',
            'descript_projet' => 'ce projet vise a donner un moyen aux etudiants de l universiter de Dschang de pouvoir avoir leurs Restaurants a travers  une plateforme dedie a cela',
            'user_id'=>'2',
            'tbl_niveau_id'=>'1',
            'tbl_categorie_id'=>'1',
        ]);
    }


}
