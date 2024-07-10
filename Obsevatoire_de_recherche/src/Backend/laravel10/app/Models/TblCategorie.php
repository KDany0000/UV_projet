<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * @OA\Schema(
 *     schema="TblCategorie",
 *     type="object",
 *     title="TblCategorie",
 *     required={"nom_cat", "descript_cat"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the category"
 *     ),
 *     @OA\Property(
 *         property="nom_cat",
 *         type="string",
 *         description="Name of the category"
 *     ),
 *     @OA\Property(
 *         property="descript_cat",
 *         type="string",
 *         description="Description of the category"
 *     )
 * )
 */

class TblCategorie extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_cat',
        'descript_cat',
    ];

    public function projets()
    {
        return $this->hasMany(TblProjet::class, 'tbl_categorie_id');
    }


    // Définit les champs indexables pour Laravel Scout
    public function toSearchableArray()
    {
        return [
            'nom_cat' => $this->nom_cat,
            'descript_cat' => $this->descript_cat,
        ];
    }

    // Définir l'index spécifique pour ce modèle
    // public function searchableAs()
    // {
    //     return 'tbl_categories';
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
