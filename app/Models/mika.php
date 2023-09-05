<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mika extends Model
{
    use HasFactory;
    protected $fillable = ['nisn','nama', 'jurusan'];
    protected $table = 'mika';
    public $timestamps = false;
}
