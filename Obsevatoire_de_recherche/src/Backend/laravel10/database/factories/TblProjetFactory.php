<?php

namespace Database\Factories;

use App\Models\TblCategorie;
use App\Models\TblNiveau;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TblProjetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\TblProjet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titre_projet' => $this->faker->unique()->realTextBetween(100,200,1),
            'descript_projet' => $this->faker->realTextBetween(1000,10000,1),
            'image'=>$this->faker->filePath(),
            'tbl_niveau_id' => TblNiveau::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'tbl_categorie_id' => TblCategorie::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
