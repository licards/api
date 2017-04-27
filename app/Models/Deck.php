<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
