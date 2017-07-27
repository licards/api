<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
