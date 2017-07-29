<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Group
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deck[] $decks
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereUserId($value)
 */
class Group extends Model
{
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }
}
