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
            'titre_projet'=>'Détection automatique des émotions',
            'descript_projet' => 'Développement d un système utilisant l intelligence artificielle pour détecter et analyser les émotions humaines à partir de vidéos en temps réel, en utilisant des techniques de traitement d image et de reconnaissance faciale.',
            'image'=>'/storage/images/img1.jpeg',
            'status'=>'Approved',
            'user_id'=>'1',
            'tbl_niveau_id'=>'1',
            'tbl_categorie_id'=>'1',

        ]);

        TblProjet::create([
            'titre_projet'=>'Voiture autonome intelligente',
            'descript_projet' => 'Conception d un prototype de voiture autonome capable de naviguer de manière indépendante en utilisant des algorithmes d apprentissage profond pour la reconnaissance des panneaux de signalisation et des obstacles.',
            'image'=>'/storage/images/img2.jpeg',
            'user_id'=>'2',
            'tbl_niveau_id'=>'1',
            'tbl_categorie_id'=>'1',
        ]);


    TblProjet::create([
        'titre_projet'=>'Système de détection d intrusion',
        'descript_projet' => 'Création d un système de détection d intrusion en temps réel pour les réseaux informatiques, utilisant des techniques d analyse comportementale et d apprentissage automatique pour identifier les activités suspectes.',
        'image'=>'/storage/images/img3.jpeg',
        'status'=>'Approved',
        'user_id'=>'2',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'2',

    ]);

    TblProjet::create([
        'titre_projet'=>'Protection des données personnelles',
        'descript_projet' => 'Développement d une solution de protection des données personnelles en ligne, en utilisant des algorithmes de cryptographie avancée et des protocoles de sécurisation des communications.',
        'image'=>'/storage/images/img4.jpeg',
        'status'=>'Rejected',
        'user_id'=>'3',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'2',
    ]);

    TblProjet::create([
        'titre_projet'=>'Application de vote électronique',
        'descript_projet' => 'Conception d une application de vote électronique sécurisée utilisant la technologie blockchain pour garantir la transparence et lnintégrité des votes, avec des fonctionnalités de vérification de l identité des votants.',
        'image'=>'/storage/images/img5.jpeg',
        'user_id'=>'2',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'3',

    ]);

    TblProjet::create([
        'titre_projet'=>'Gestion des chaînes d approvisionnement',
        'descript_projet' => 'Développement d une plateforme de gestion des chaînes d approvisionnement basée sur la blockchain pour suivre et vérifier l authenticité et la provenance des produits tout au long de la chaîne logistique.',
        'image'=>'/storage/images/img6.jpeg',
        'status'=>'Approved',
        'user_id'=>'4',
        'tbl_niveau_id'=>'4',
        'tbl_categorie_id'=>'3',
    ]);

    TblProjet::create([
        'titre_projet'=>'Optimisation des réseaux sans fil',
        'descript_projet' => ' Étude et mise en œuvre de techniques d optimisation pour les réseaux sans fil afin d améliorer la couverture, la capacité et la qualité de service, en utilisant des algorithmes de routage avancés.',
        'image'=>'/storage/images/img7.jpeg',
        'user_id'=>'2',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'4',

    ]);

    TblProjet::create([
        'titre_projet'=>'Système de gestion de la bande passante',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img8.jpeg',
        'status'=>'Rejected',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'4',
    ]);

    TblProjet::create([
        'titre_projet'=>'Analyse prédictive des ventes',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img9.jpeg',
        'user_id'=>'3',
        'tbl_niveau_id'=>'4',
        'tbl_categorie_id'=>'5',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img10.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet'=>'Optimisation des réseaux sans fils',
        'descript_projet' => ' Étude et mise en œuvre de techniques d optimisation pour les réseaux sans fil afin d améliorer la couverture, la capacité et la qualité de service, en utilisant des algorithmes de routage avancés.',
        'image'=>'/storage/images/img5.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'4',
        'tbl_categorie_id'=>'4',

    ]);

    TblProjet::create([
        'titre_projet'=>'Système de gestion de la bande passantes',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img2.jpeg',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet'=>'Analyse prédictive des ventes, stock et achats',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img5.jpeg',
        'status'=>'Approved',
        'user_id'=>'3',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'1',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières partie2',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img8.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'2',
    ]);

    TblProjet::create([
        'titre_projet'=>'Analyse prédictive des ventes et achat',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img7.jpeg',
        'status'=>'Rejected',
        'user_id'=>'3',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'2',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières partie3',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img3.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'3',
    ]);

    TblProjet::create([
        'titre_projet'=>'Analyse prédictive des ventes et achats',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img5.jpeg',
        'status'=>'Approved',
        'user_id'=>'3',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'1',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières partie5',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img2.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'2',
    ]);

    TblProjet::create([
        'titre_projet'=>'Gestion des hotels',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img1.jpeg',
        'status'=>'Approved',
        'user_id'=>'3',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'3',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières partie4',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img6.jpeg',
        'status'=>'Approved',
        'user_id'=>'3',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet'=>'Gestion des hotels et bar',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img5.jpeg',
        'status'=>'Rejected',
        'user_id'=>'5',
        'tbl_niveau_id'=>'1',
        'tbl_categorie_id'=>'3',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières et economique',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img6.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières partie6',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img1.jpeg',
        'status'=>'Approved',
        'user_id'=>'3',
        'tbl_niveau_id'=>'3',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet'=>'Gestion des hotels et bars',
        'descript_projet' => ' Utilisation des techniques de data science et d apprentissage automatique pour analyser les données de ventes historiques et prédire les tendances futures, afin  d aider les entreprises à optimiser leur stratégie commerciale.',
        'image'=>'/storage/images/img2.jpeg',
        'status'=>'Rejected',
        'user_id'=>'5',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'3',

    ]);

    TblProjet::create([
        'titre_projet'=>'Détection de fraudes financières et economiques',
        'descript_projet' => 'Développement d un système de gestion de la bande passante pour les réseaux d entreprise, permettant de prioriser le trafic réseau et d allouer dynamiquement les ressources en fonction des besoins.',
        'image'=>'/storage/images/img6.jpeg',
        'status'=>'Approved',
        'user_id'=>'1',
        'tbl_niveau_id'=>'2',
        'tbl_categorie_id'=>'5',
    ]);

    TblProjet::create([
        'titre_projet' => 'Analyse des tendances de marché',
        'descript_projet' => 'Développement d’un outil d’analyse des tendances du marché utilisant des algorithmes de machine learning pour prédire les mouvements futurs.',
        'image' => '/storage/images/img1.jpeg',
        'status' => 'Approved',
        'user_id' => '1',
        'tbl_niveau_id' => '3',
        'tbl_categorie_id' => '2',
    ]);

    TblProjet::create([
        'titre_projet' => 'Système de recommandation de films',
        'descript_projet' => 'Création d’un système de recommandation de films basé sur les préférences de l’utilisateur et l’historique de visionnage.',
        'image' => '/storage/images/img2.jpeg',
        'status' => 'Rejected',
        'user_id' => '2',
        'tbl_niveau_id' => '5',
        'tbl_categorie_id' => '4',
    ]);

    TblProjet::create([
        'titre_projet' => 'Application de gestion de tâches',
        'descript_projet' => 'Développement d’une application mobile pour la gestion des tâches et des projets avec des fonctionnalités de collaboration en temps réel.',
        'image' => '/storage/images/img3.jpeg',
        'status' => 'Pending',
        'user_id' => '3',
        'tbl_niveau_id' => '7',
        'tbl_categorie_id' => '5',
    ]);

    TblProjet::create([
        'titre_projet' => 'Plateforme de e-commerce',
        'descript_projet' => 'Conception d’une plateforme de commerce électronique avec des options de paiement sécurisées et une interface utilisateur intuitive.',
        'image' => '/storage/images/img4.jpeg',
        'status' => 'Approved',
        'user_id' => '4',
        'tbl_niveau_id' => '8',
        'tbl_categorie_id' => '1',
    ]);

    TblProjet::create([
        'titre_projet' => 'Système de gestion de la santé',
        'descript_projet' => 'Développement d’un système intégré de gestion des dossiers de santé pour les hôpitaux et les cliniques.',
        'image' => '/storage/images/img5.jpeg',
        'status' => 'Rejected',
        'user_id' => '5',
        'tbl_niveau_id' => '10',
        'tbl_categorie_id' => '6',
    ]);

    TblProjet::create([
        'titre_projet' => 'Détection d’intrusion dans les réseaux',
        'descript_projet' => 'Mise en place d’un système de détection d’intrusion pour protéger les réseaux d’entreprise contre les cyberattaques.',
        'image' => '/storage/images/img6.jpeg',
        'status' => 'Pending',
        'user_id' => '1',
        'tbl_niveau_id' => '11',
        'tbl_categorie_id' => '4',
    ]);

    TblProjet::create([
        'titre_projet' => 'Application de fitness',
        'descript_projet' => 'Développement d’une application de suivi de la condition physique et de la nutrition avec des fonctionnalités de coaching personnalisé.',
        'image' => '/storage/images/img7.jpeg',
        'status' => 'Approved',
        'user_id' => '2',
        'tbl_niveau_id' => '9',
        'tbl_categorie_id' => '5',
    ]);

    TblProjet::create([
        'titre_projet' => 'Système de réservation en ligne',
        'descript_projet' => 'Création d’un système de réservation en ligne pour les hôtels et les restaurants avec une gestion intégrée des disponibilités.',
        'image' => '/storage/images/img8.jpeg',
        'status' => 'Rejected',
        'user_id' => '3',
        'tbl_niveau_id' => '4',
        'tbl_categorie_id' => '3',
    ]);

    TblProjet::create([
        'titre_projet' => 'Reconnaissance faciale',
        'descript_projet' => 'Développement d’un système de reconnaissance faciale pour améliorer la sécurité et l’accès aux bâtiments.',
        'image' => '/storage/images/img9.jpeg',
        'status' => 'Pending',
        'user_id' => '4',
        'tbl_niveau_id' => '6',
        'tbl_categorie_id' => '6',
    ]);

    TblProjet::create([
        'titre_projet' => 'Analyse des sentiments sur les réseaux sociaux',
        'descript_projet' => 'Mise en place d’un outil d’analyse des sentiments pour surveiller et analyser les opinions sur les réseaux sociaux.',
        'image' => '/storage/images/img10.jpeg',
        'status' => 'Approved',
        'user_id' => '5',
        'tbl_niveau_id' => '2',
        'tbl_categorie_id' => '5',
    ]);


}

}
