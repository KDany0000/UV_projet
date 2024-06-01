<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
