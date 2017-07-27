<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract
{
    public function transform($field)
    {
        $data = [
            'id' => $field->id,
            'deck_id' => $field->deck_id,
            'name' => $field->name,
            'clue' => $field->clue,
        ];

        if($field->pivot && $field->pivot->value) {
            $data['value'] = $field->pivot->value;
        }

        return $data;
    }
}
