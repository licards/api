<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
