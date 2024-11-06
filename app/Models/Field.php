<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'contact', 'price', 'modality', 'image', 'user_id'];


    // Relacionamento com o usuário (campo do tipo 'user_field')
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
