<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class DeckTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return $resource->toArray();
    }
}
