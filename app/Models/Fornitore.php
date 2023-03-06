<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Incarico;

class Fornitore extends Model
{
    use HasFactory;

    protected $table = 'fornitori';

    protected $fillable = ['rag_soc','telefono','cellulare','email','codice_fiscale','partita_iva','disciplina','user_id','via','comune','provincia','cap','nazione','note'];
    
    public function incarichi()
    {
        return $this->hasMany(Incarico::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
