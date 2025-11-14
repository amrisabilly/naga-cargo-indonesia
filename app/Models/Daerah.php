<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;

    protected $table = 'daerah';
    protected $primaryKey = 'id_daerah';

    protected $fillable = [
        'kode_daerah',
        'nama',
    ];
}