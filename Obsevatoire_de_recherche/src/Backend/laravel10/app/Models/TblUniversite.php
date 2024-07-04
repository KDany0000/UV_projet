<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblUniversite",
 *     type="object",
 *     title="TblUniversite",
 *     required={"nom_univ", "localite_univ", "email_univ", "boite_postale"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the universite"
 *     ),
 *     @OA\Property(
 *         property="nom_univ",
 *         type="string",
 *         description="Name of the universite"
 *     ),
 *     @OA\Property(
 *         property="localite_univ",
 *         type="string",
 *         description="Location of the universite"
 *     ),
 *     @OA\Property(
 *         property="email_univ",
 *         type="string",
 *         description="Email of the universite"
 *     ),
 *     @OA\Property(
 *         property="boite_postale",
 *         type="string",
 *         description="Postal box of the universite"
 *     )
 * )
 */

class TblUniversite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_univ',
        'localite_univ',
        'email_univ',
        'boite_postale',
    ];

    public function facultes()
    {
        return $this->hasMany(TblFaculte::class);
    }

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
