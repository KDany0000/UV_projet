<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TblFaculte",
 *     type="object",
 *     title="TblFaculte",
 *     required={"nom_fac", "email_fac", "tbl_universite_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the faculty"
 *     ),
 *     @OA\Property(
 *         property="nom_fac",
 *         type="string",
 *         description="Name of the faculty"
 *     ),
 *     @OA\Property(
 *         property="email_fac",
 *         type="string",
 *         description="Email of the faculty"
 *     ),
 *     @OA\Property(
 *         property="tbl_universite_id",
 *         type="integer",
 *         description="ID of the related university"
 *     )
 * )
 */

class TblFaculte extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_fac',
        'email_fac',
        'tbl_universite_id',
    ];

    public function universite()
    {
        return $this->belongsTo(TblUniversite::class);
    }

    public function filieres()
    {
        return $this->hasMany(TblFiliere::class);
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
