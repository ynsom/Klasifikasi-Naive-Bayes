<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplication extends Model
{
    use HasFactory;

    protected $guarded= ['id'];

    public function Review()
    {
        return $this->hasMany(Reviews::class, 'application_id');
    }
}
