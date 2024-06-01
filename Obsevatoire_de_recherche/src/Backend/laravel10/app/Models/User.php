<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_user',
        'email',
        'tel_user',
        'tbl_filiere_id',
        'password',
    ];

    public function filiere()
    {
        return $this->belongsTo(TblFiliere::class);
    }

    public function projets()
    {
        return $this->hasMany(TblProjet::class);
    }

    public function documents()
    {
        return $this->hasMany(TblDocument::class);
    }

    public function collaborateurs()
    {
        return $this->belongsToMany(TblCollaborateur::class, 'collaborateur_utilisateur');
    }

    public function superviseurss()
    {
        return $this->belongsToMany(TblSuperviseur::class, 'superviseur_utilisateur');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
