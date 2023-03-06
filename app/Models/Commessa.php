<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Offerta;
use App\Models\Incarico;
use App\Models\User;

class Commessa extends Model
{
    use HasFactory;

    protected $table = 'commesse';

    protected $fillable = [
        'codice',
        'company_id',
        'user_id',
        'customer_id',
        'offerta_id',
        'description',
        'data_apertura',
        'data_stim_chiusura',
        'data_effettiva_chiusura',
        'val_iniziale',
        'val_no_finanz',
        'val_finanz',
        'stato',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function offerta()
    {
        return $this->belongsTo(Offerta::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incarichi()
    {
        return $this->hasMany(Incarico::class);
    }
}
