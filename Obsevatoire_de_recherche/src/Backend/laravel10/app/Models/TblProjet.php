<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TblProjet extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre_projet',
        'descript_projet',
        'superviseurs',
        'tbl_niveau_id',
        'tbl_categorie_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function niveau()
    {
        return $this->belongsTo(TblNiveau::class);
    }

    public function categorie()
    {
        return $this->belongsTo(TblCategorie::class);
    }

    public function documents()
    {
        return $this->hasMany(TblDocument::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'collaborateur_projets');
    }

    public function superviseurs()
    {
        return $this->belongsToMany(TblSuperviseur::class, 'projet_superviseurs');
    }

    public function collaborateurs()
    {
        return $this->belongsToMany(TblCollaborateur::class, 'collaborateur_projets');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'titre_projet' => $array['titre_projet'],
            'descript_projet' => $array['descript_projet'],
        ];
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
