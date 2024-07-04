<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblSuperviseur",
 *     type="object",
 *     title="TblSuperviseur",
 *     required={"nom_sup", "email_sup"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the superviseur"
 *     ),
 *     @OA\Property(
 *         property="nom_sup",
 *         type="string",
 *         description="Name of the superviseur"
 *     ),
 *     @OA\Property(
 *         property="email_sup",
 *         type="string",
 *         description="Email of the superviseur"
 *     )
 * )
 */

class TblSuperviseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_sup',
        'email_sup',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'superviseur_utilisateurs');
    }

    public function projets()
    {
        return $this->belongsToMany(TblProjet::class, 'projet_superviseurs');
    }
}
