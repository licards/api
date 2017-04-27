<?php

namespace App\Http\Transformers;

use App\Models\Deck;
use League\Fractal\TransformerAbstract;

class DeckTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'cards',
        'fields',
        'tags',
    ];

    protected function includeCards(Deck $deck) {
        return $this->collection($deck->cards, new CardTransformer);
    }

    protected function includeFields(Deck $deck) {
        return $this->collection($deck->fields, new FieldTransformer);
    }

    protected function includeTags(Deck $deck) {
        return $this->collection($deck->tags, new TagTransformer);
    }

    public function transform(Deck $deck)
    {
        return [
            'id' => $deck->id,
            'user_id' => $deck->user_id,
            'name' => $deck->name,
            'cards_total' => $deck->cards->count(),
        ];
    }
}
