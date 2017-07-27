<?php

namespace App\Http\Transformers;

use App\Models\Deck;
use League\Fractal\TransformerAbstract;

class DeckTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'categories',
    ];

    public function transform(Deck $deck)
    {
        return $deck->toArray();
    }

    public function includeCategories(Deck $deck)
    {
        return $this->collection($deck->categories, new CategoryTransformer());
    }
}
