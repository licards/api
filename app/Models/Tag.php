<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }
}
