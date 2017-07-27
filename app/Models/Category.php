<?php

namespace App\Models;

use Baum\Node;

/**
 * Category
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
