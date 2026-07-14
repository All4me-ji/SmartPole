<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $primaryKey = 'utilisateur_id';

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
	'statut',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function poles()
    {
        return $this->hasMany(Pole::class, 'manager_id', 'utilisateur_id');
    }
}