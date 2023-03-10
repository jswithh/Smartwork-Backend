<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Knowledge_Base extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'knowledge_bases';

    protected $fillable = [
        'category_knowledge_id',
        'tittle',
        'description',
        'url',
    ];

    public function category_knowledge()
    {
        return $this->belongsTo(Category_Knowledge::class);
    }
}
