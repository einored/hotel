<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country as C;

class Hotel extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(C::class, 'country_id', 'id');
    }
}
