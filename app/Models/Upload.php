<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    protected $table="uploads";
    protected $fillable = [
        'file',
        'file_type',
        'relation_id',
        'folder',
    ];


}
