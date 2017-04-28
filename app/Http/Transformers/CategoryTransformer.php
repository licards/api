<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'parent_id' => $resource->parent_id,
            'decks_count' => $resource->decks->count(),
        ];
    }
}