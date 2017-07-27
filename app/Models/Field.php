<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
