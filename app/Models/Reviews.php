<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $guarded= ['id'];

    public function Sentimen()
    {
        return $this->hasMany(Sentimen::class, 'review_id');
    }

    public function Application()
    {
        return $this->belongsTo(Aplication::class, 'application_id');
    }
}
