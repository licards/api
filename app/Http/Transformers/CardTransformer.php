<?php

namespace App\Http\Transformers;

use App\Models\Card;
use League\Fractal\TransformerAbstract;

class CardTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'fields'
    ];

    public function transform(Card $card)
    {
        return $card->toArray();
    }

    public function includeFields(Card $card)
    {
        $fields = $card->fields;

        return $this->collection($fields, new FieldTransformer);
    }
}
