<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel as H;
use App\Models\User as U;

class Order extends Model
{
    use HasFactory;

    public function hotel()
    {
        return $this->belongsTo(H::class, 'hotel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(U::class, 'user_id', 'id');
    }
}

