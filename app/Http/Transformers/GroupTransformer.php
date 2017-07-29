<?php

namespace App\Http\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'decks',
    ];

    public function transform(Group $group)
    {
        return $group->toArray();
    }

    public function includeDecks(Group $group)
    {
        return $this->collection($group->decks, new DeckTransformer());
    }
}
