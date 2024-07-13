<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TblProjet;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $faker = FakerFactory::create('fr_FR');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UniversiteSeeder::class);
        $this->call(FaculteSeeder::class);
        $this->call(FiliereSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NiveauSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(ProjetSeeder::class);
        $this->call(DocumentSeeder::class);


        //TblProjet::factory()->count(10)->create();
    }
}
