<?php

namespace App\Http\Transformers;

use App\Models\Field;
use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract
{
    public function transform(Field $field)
    {
        return $field->toArray();
    }
}
