<?php

namespace App\Http\Transformers;

use App\Models\Card;
use League\Fractal\TransformerAbstract;

class CardTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'fields'
    ];

    protected function includeFields(Card $card)
    {
        return $this->collection($card->fields, new FieldTransformer);
    }

    public function transform($card)
    {
        return [
            'id' => $card->id,
            'deck_id' => $card->deck_id,
        ];
    }
}
