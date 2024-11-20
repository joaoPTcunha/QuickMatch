<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'contact', 'price', 'modality', 'image', 'user_id'];

    // Especifica que a chave primária é um UUID e não um inteiro auto-incremental
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                // Gerar UUID caso o campo 'id' esteja vazio
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Definindo a relação com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
