<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function deck() {
        return $this->belongsTo(Deck::class);
    }
}
