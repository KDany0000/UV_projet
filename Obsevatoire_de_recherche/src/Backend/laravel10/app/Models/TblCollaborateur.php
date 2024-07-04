<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblCollaborateur",
 *     type="object",
 *     title="TblCollaborateur",
 *     required={"nom_collab", "email_collab"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the collaborator"
 *     ),
 *     @OA\Property(
 *         property="nom_collab",
 *         type="string",
 *         description="Name of the collaborator"
 *     ),
 *     @OA\Property(
 *         property="email_collab",
 *         type="string",
 *         description="Email of the collaborator"
 *     )
 * )
 */

class TblCollaborateur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_collab',
        'email_collab',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'collaborateur_utilisateur');
    }

    public function projets()
    {
        return $this->belongsToMany(TblProjet::class, 'collaborateur_projet');
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
