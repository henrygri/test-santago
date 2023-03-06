<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Ruoli extends Model
{
    use HasFactory;

    protected $table = 'ruoli';

    protected $fillable = ['nome'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
