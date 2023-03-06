<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'users_details';

    protected $fillable = [
        'user_id',
        'fiscal_code',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
