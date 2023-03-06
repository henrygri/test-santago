<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BandiCorso;

class Corso extends Model
{
    use HasFactory;

    protected $table = 'corsi';

    protected $fillable = [
        'titolo',
        'edizioni',
        'ore'
    ];

    public function relazione_bando()
    {
        return $this->hasOne(BandiCorso::class);
    }

    public function bandi()
    {
        return $this->hasMany(BandiCorso::class, 'corso_id');
    }
}
