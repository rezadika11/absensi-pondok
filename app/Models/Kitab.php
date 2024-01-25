<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitab extends Model
{
    use HasFactory;
    protected $table = 'kitab';
    protected $primaryKey = 'id_kitab';
    protected $fillable = [
        'nama',
    ];
}
