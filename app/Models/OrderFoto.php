<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFoto extends Model
{
    use HasFactory;

    protected $table = 'order_foto';

    protected $fillable = [
        'AWB',
        'path_foto',
        'tanggal_upload',
        'keterangan',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'AWB', 'AWB');
    }
}