<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = 
    [
        'controleexterno',
        'nome'
    ];

    public function tags() {
        return $this->belongsToMany(
            Tag::class,
            'produto_tags',
            'produto_id',
            'tag_id'
        );
    }
}