<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblCollaborateurProjet",
 *     type="object",
 *     title="TblCollaborateurProjet",
 *     required={"tbl_projet_id", "tbl_collaborateur_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the collaboration project"
 *     ),
 *     @OA\Property(
 *         property="tbl_projet_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the project"
 *     ),
 *     @OA\Property(
 *         property="tbl_collaborateur_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the collaborator"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Update timestamp"
 *     )
 * )
 */
class TblCollaborateurProjet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tbl_projet_id',
        'tbl_collaborateur_id',
    ];

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

