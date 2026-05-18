<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NisTemplate extends Model
{
    protected $fillable = ['nis', 'nama', 'kelas', 'jurusan'];
}
