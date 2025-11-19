<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $primaryKey = 'AWB';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'AWB',
        'id_PIC',
        'id_user',
        'id_daerah',
        'tujuan',
        'penerima',
        'no_hp',
        'tanggal',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user',);
    }

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'id_daerah', 'id_daerah');
    }
    public function pic()
    {
        return $this->belongsTo(User::class, 'id_PIC', 'id_user');
    }
}
