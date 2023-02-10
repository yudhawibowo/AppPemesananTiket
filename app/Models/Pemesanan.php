<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
