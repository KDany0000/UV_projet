<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblNiveau",
 *     type="object",
 *     title="TblNiveau",
 *     required={"code_niv"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the niveau"
 *     ),
 *     @OA\Property(
 *         property="code_niv",
 *         type="string",
 *         description="Code of the niveau"
 *     )
 * )
 */

class TblNiveau extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_niv',
    ];

    public function projets()
    {
        return $this->hasMany(TblProjet::class, 'tbl_niveau_id');
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
