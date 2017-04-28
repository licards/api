<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'children'
    ];

    public function transform($resource)
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'parent_id' => $resource->parent_id,
            'decks_count' => $resource->decks->count(),
            'children' => $resource->getDescendants()->map(function($descendant) {
                return $this->transform($descendant);
            })
        ];
    }
}
