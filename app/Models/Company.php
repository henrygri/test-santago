<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Settori;
use App\Models\User;
use App\Models\Offerta;
use App\Models\Commessa;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rag_soc',
        'settore_id',
        'cod_fisc',
        'p_iva',
        'p_iva_collegata',
        'phone',
        'tipo', 
        'indirizzo_legale',
        'comune_legale',
        'provincia_legale',
        'cap_legale',
        'regione_legale',
        'nazione_legale',
        'indirizzo_legale',
        'comune_legale',
        // 'indirizzo_operativo',
        // 'comune_operativo',
        // 'provincia_operativo',
        // 'cap_operativo',
        // 'regione_operativo',
        // 'nazione_operativo',
        'sedi',
        'tipologia_organizzativa',
        'fatturato_annuo',
        'n_dipendenti',
        'data_ricontattare',
        'data_contatto',
        'come_ci_ha_conosciuto',
        'fondo_dirigenti',
        'fondo_non_dirigenti',
        'rsa_rsu',
        'privato',
        'fornitori_attuali',
        'potenziale_fatturato_formazione',
        'potenziale_fatturato_selezione',
        'potenziale_fatturato_pal',
        'potenziale_fatturato_consulenza',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function settore()
    {
        return $this->belongsTo(Settori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offerte()
    {
        return $this->hasMany(Offerta::class);
    }

    public function commesse()
    {
        return $this->hasMany(Commessa::class);
    }
}
