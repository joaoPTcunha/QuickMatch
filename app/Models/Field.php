<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id', 'name', 'description', 'location', 'contact', 'price', 'modality', 'image'
    ];

    // Relacionamento com o modelo 'User' (campo criado por um usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o modelo 'Event' (campo pode ter muitos eventos)
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
