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
             'icone' => '/storage/images_cat/image1.jpeg',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Cyber Sécurité',
            'descript_cat'=>'Protection des systèmes informatiques et des données contre les cyberattaques et les accès non autorisés.',
             'icone' => '/storage/images_cat/image6.jpeg',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Blockchain',
            'descript_cat'=>'Technologie de registre distribué garantissant la sécurité, la transparence et l immuabilité des transactions.',
             'icone' => '/storage/images_cat/image3.jpeg',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Réseau',
            'descript_cat'=>'Conception et gestion des infrastructures de communication pour assurer la connectivité et l échange de données.',
            'icone' => '/storage/images_cat/image2.jpeg',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Data Science',
            'descript_cat'=>'Extraction de connaissances et d insights à partir de grandes quantités de données via des techniques analytiques et statistiques.',
             'icone' => '/storage/images_cat/image4.jpeg',
        ]);

        TblCategorie::create([
            'nom_cat'=>'Génie Logiciel',
            'descript_cat'=>'Développement, maintenance et gestion de systèmes logiciels pour répondre aux besoins spécifiques des utilisateurs.',
             'icone' => '/storage/images_cat/image5.jpeg',
        ]);
    }
}
