<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\Company;
use App\Models\Bando;
use App\Models\Commessa;
use App\Models\Service;
use App\Models\Corso;

class Offerta extends Model
{
    use HasFactory;

    protected $table = 'offerte';

    protected $fillable = [
        'company_id',
        'customer_id',
        'user_id',
        'bando_id',
        'codice',
        'description',
        'data_richiesta_preventivo',
        'data_scadenza_preventivo',
        'stato',
        'val_offerta_tot',
        'finanziamento',
        'corso_id',
        'n_edizione', 
        'val_offerta_no_finanz',
        'val_offerta_finanz',
        'individuale_gruppo',
        'note'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bando()
    {
        return $this->belongsTo(Bando::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commesse()
    {
        return $this->hasMany(Commessa::class);
    }

    public function corso()
    {
        return $this->belongsTo(Corso::class);
    }
}
