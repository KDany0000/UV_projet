<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


/**
 * @OA\Schema(
 *     schema="TblDocument",
 *     type="object",
 *     title="TblDocument",
 *     required={"nom_doc", "lien_doc", "type_doc", "resume", "tbl_projet_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the document"
 *     ),
 *     @OA\Property(
 *         property="nom_doc",
 *         type="string",
 *         description="Name of the document"
 *     ),
 *     @OA\Property(
 *         property="lien_doc",
 *         type="string",
 *         description="Link to the document"
 *     ),
 *     @OA\Property(
 *         property="type_doc",
 *         type="string",
 *         description="Type of the document (PDF, WORD, POWEPOINT)"
 *     ),
 *     @OA\Property(
 *         property="resume",
 *         type="string",
 *         description="Summary of the document"
 *     ),
 *     @OA\Property(
 *         property="tbl_projet_id",
 *         type="integer",
 *         description="ID of the related project"
 *     )
 * )
 */

class TblDocument extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_doc',
        'lien_doc',
        'user_id',
        'tbl_projet_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projet()
    {
        return $this->belongsTo(TblProjet::class);
    }


    // Définit les champs indexables pour Laravel Scout
    public function toSearchableArray()
    {
        return [
            'nom_doc' => $this->nom_doc,
        ];
    }

    // Définir l'index spécifique pour ce modèle
    // public function searchableAs()
    // {
    //     return 'tbl_documents';
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
