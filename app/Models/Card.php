<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Card
 *
 * @property-read \App\Models\Deck $deck
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Field[] $fields
 * @mixin \Eloquent
 * @property int $id
 * @property int $deck_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereDeckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUpdatedAt($value)
 */
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
