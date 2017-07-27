<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = [
        'name',
    ];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
