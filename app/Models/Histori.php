<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    use HasFactory;

    protected $table = 'histori';

    protected $fillable = ['document_id', 'user_id', 'sent', 'accepted'];
}
