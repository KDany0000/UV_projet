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
            'nom_cat'=>'Intelligence Artificielle (IA)',
            'descript_cat'=>'Utilisation d algorithmes et de modèles pour simuler l intelligence humaine et automatiser des tâches complexes.',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Cyber Sécurité',
            'descript_cat'=>'Protection des systèmes informatiques et des données contre les cyberattaques et les accès non autorisés.',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Blockchain',
            'descript_cat'=>'Technologie de registre distribué garantissant la sécurité, la transparence et l immuabilité des transactions.',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Réseau',
            'descript_cat'=>'Conception et gestion des infrastructures de communication pour assurer la connectivité et l échange de données.',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Data Science',
            'descript_cat'=>'Extraction de connaissances et d insights à partir de grandes quantités de données via des techniques analytiques et statistiques.',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Génie Logiciel',
            'descript_cat'=>'Développement, maintenance et gestion de systèmes logiciels pour répondre aux besoins spécifiques des utilisateurs.',
        ]);
    }
}
