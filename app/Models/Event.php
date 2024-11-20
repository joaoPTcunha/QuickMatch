<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 
        'event_date_time', 
        'num_participantes', 
        'price', 
        'modality', 
        'field_id',
        'user_id'
    ];

    // Ensure your relationships are set up
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}