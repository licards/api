<?php

namespace App\Models;

use Baum\Node;

/**
 * Category
 *
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deck[] $decks
 * @property-read \App\Models\Category $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node limitDepth($limit)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutSelf()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 */
class Category extends Node
{

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }

}
