<?php

namespace App\Http\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'deck_id' => $tag->deck_id,
            'name' => $tag->name,
        ];
    }
}