<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblProjetSuperviseur",
 *     type="object",
 *     title="TblProjetSuperviseur",
 *     required={"tbl_projet_id", "tbl_superviseur_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the project-supervisor relationship"
 *     ),
 *     @OA\Property(
 *         property="tbl_projet_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the project"
 *     ),
 *     @OA\Property(
 *         property="tbl_superviseur_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the supervisor"
 *     )
 * )
 */
class TblProjetSuperviseur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tbl_projet_id',
        'tbl_superviseur_id',
    ];
}
