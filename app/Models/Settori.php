<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settori extends Model
{
    use HasFactory;

    protected $table = 'settori';

    protected $fillable = ['nome'];
}
