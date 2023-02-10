<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];
    protected $guarded=[];
    protected $fillable = [
        'name',
    ];

    public function avatar()
    {
        return $this->belongsTo(Upload::class, 'id','relation_id')->where('file_type','brands');
    }
}
