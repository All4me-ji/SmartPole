<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'production';

    protected $primaryKey = 'production_id';

    protected $fillable = [
        'date',
        'produit',
        'quantite',
        'pole_id',
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class, 'pole_id', 'pole_id');
    }
}