<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Corso;
use App\Models\Bando;

class BandiCorso extends Model
{
    use HasFactory;

    protected $table = 'bandi_corsi';

    public $timestamps = false;

    protected $fillable = [
        'bando_id',
        'corso_id',
    ];

    public function corso()
    {
        return $this->belongsTo(Corso::class);
    }

    public function bando()
    {
        return $this->belongsTo(Bando::class);
    }
}
