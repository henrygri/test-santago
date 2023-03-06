<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BandiCorso;

class Bando extends Model
{
    use HasFactory;

    protected $table = 'bandi';

    protected $fillable = [
        'nome',
        'codice',
        'data_apertura',
        'data_chiusura',
        'data_chiusura_prorogata',
        'valore_iniziale',
        'valore_finale',
        'monte_ore',
        'note'
    ];

    public function corsi()
    {
        return $this->hasMany(BandiCorso::class);
    }
}
