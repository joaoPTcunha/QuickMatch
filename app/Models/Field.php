<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'location',
        'contact',
        'price',
        'modality',
        'image',
        'availability',  // Adicionando o campo availability
    ];

    // Definir os castings para garantir que availability seja tratado como um array
    protected $casts = [
        'availability' => 'array',  // Cast do campo availability para array
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com os eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
