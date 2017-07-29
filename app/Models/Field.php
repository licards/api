<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Field
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read \App\Models\Field $deck
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $deck_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereDeckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereUpdatedAt($value)
 */
class Field extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }

    public function deck()
    {
        return $this->belongsTo(Field::class);
    }
}
