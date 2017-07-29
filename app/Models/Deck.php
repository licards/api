<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Deck
 *
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Field[] $fields
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $public
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Deck whereUserId($value)
 */
class Deck extends Model
{
    protected $fillable = [
        'name',
        'public',
    ];

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
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
