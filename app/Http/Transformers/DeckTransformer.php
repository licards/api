<?php

namespace App\Http\Transformers;

use App\Models\Deck;
use League\Fractal\TransformerAbstract;

class DeckTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'categories',
        'tags',
        'groups',
        'fields',
    ];

    public function transform(Deck $deck)
    {
        return $deck->toArray();
    }

    public function includeCategories(Deck $deck)
    {
        return $this->collection($deck->categories, new CategoryTransformer());
    }

    public function includeTags(Deck $deck)
    {
        return $this->collection($deck->tags, new TagTransformer());
    }

    public function includeGroups(Deck $deck)
    {
        return $this->collection($deck->groups, new GroupTransformer());
    }

    public function includeFields(Deck $deck)
    {
        return $this->collection($deck->fields, new FieldTransformer());
    }
}
