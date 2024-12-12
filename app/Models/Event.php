<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'description',
        'event_date_time',
        'price',
        'modality',
        'status',
        'num_participants',
        'num_subscribers',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

   public function incrementInscritos()
{
    $this->increment('num_subscribers');
}



}