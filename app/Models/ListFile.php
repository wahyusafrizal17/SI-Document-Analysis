<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListFile extends Model
{
    use HasFactory;

    protected $table = 'list_file';

    protected $fillable = ['document_id', 'source_id'];
}
