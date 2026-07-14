<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $primaryKey = 'vente_id';

    protected $fillable = [
        'date',
        'montant',
        'cout',
        'benefice',
        'pole_id',
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class, 'pole_id', 'pole_id');
    }
}
