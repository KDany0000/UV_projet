<?php

namespace Database\Seeders;

use App\Models\TblDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblDocument::create([
            'nom_doc'=>'Liste des Etudiants',
            'lien_doc' => 'path/to/doc1',
            'tbl_projet_id'=>'1',
            'user_id'=>'1',
        ]);

        TblDocument::create([
            'nom_doc'=>'Statistiques',
            'lien_doc' => 'path/to/doc2',
            'tbl_projet_id'=>'1',
            'user_id'=>'1',
        ]);

        TblDocument::create([
            'nom_doc'=>'liste des projets',
            'lien_doc' => 'path/to/doc3',
            'tbl_projet_id'=>'1',
            'user_id'=>'2',
        ]);

        TblDocument::create([
            'nom_doc'=>'fichier utiles',
            'lien_doc' => 'path/to/doc4',
            'tbl_projet_id'=>'1',
            'user_id'=>'3',
        ]);
    }
}
