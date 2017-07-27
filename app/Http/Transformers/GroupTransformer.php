<?php

namespace App\Http\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'decks'
    ];

    protected function includeDecks(Group $group)
    {
        return $this->collection($group->decks, new DeckTransformer);
    }

    public function transform(Group $group)
    {
        return [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name,
        ];
    }
}
