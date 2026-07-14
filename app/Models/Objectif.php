<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    protected $primaryKey = 'objectif_id';

    protected $fillable = [
        'cible',
        'periode',
        'pole_id',
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class, 'pole_id', 'pole_id');
    }
}