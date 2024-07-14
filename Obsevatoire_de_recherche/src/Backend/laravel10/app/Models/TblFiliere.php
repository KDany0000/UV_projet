<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TblFiliere",
 *     type="object",
 *     title="TblFiliere",
 *     required={"nom_fil", "tbl_faculte_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the filiere"
 *     ),
 *     @OA\Property(
 *         property="nom_fil",
 *         type="string",
 *         description="Name of the filiere"
 *     ),
 *     @OA\Property(
 *         property="tbl_faculte_id",
 *         type="integer",
 *         description="ID of the related faculte"
 *     )
 * )
 */

class TblFiliere extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_fil',
        'tbl_faculte_id',
    ];

    public function faculte()
    {
        return $this->belongsTo(TblFaculte::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tbl_filiere_id');
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
