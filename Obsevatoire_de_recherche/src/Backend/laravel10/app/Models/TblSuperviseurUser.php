<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="TblSuperviseurUser",
 *     type="object",
 *     title="TblSuperviseurUser",
 *     required={"user_id", "tbl_superviseur_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the supervisor-user relationship"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the user"
 *     ),
 *     @OA\Property(
 *         property="tbl_superviseur_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the supervisor"
 *     )
 * )
 */
class TblSuperviseurUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tbl_superviseur_id',
    ];
}
