<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deck[] $decks
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 */
class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }
}
