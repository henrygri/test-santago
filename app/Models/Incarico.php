<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;
use App\Models\Offerta;
use App\Models\Bando;
use App\Models\Fornitore;
use App\Models\Commessa;

class Incarico extends Model
{
    use HasFactory;

    protected $table = 'incarichi';

    protected $fillable = [
        'codice',
        'fornitore_id',
        'commessa_id',
        'company_id',
        'bando_id',
        'offerta_id',
        'responsabile',
        'assegnato',
        'attivita',
        'data_inizio',
        'data_fine',
        'numero_edizione',
        'tempi_pagamento',
        'ore',
        'costo_orario',
        'spese',
        'note'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function offerta()
    {
        return $this->belongsTo(Offerta::class);
    }

    public function resp()
    {
        return $this->belongsTo(User::class, 'responsabile');
    }

    public function ass()
    {
        return $this->belongsTo(User::class, 'assegnato');
    }

    public function bando()
    {
        return $this->belongsTo(Bando::class);
    }

    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class);
    }

    public function commessa()
    {
        return $this->belongsTo(Commessa::class);
    }
}
