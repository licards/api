<?php

namespace App\Http\Controllers;

use App\Http\Transformers\DeckTransformer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Deck;

class DeckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $decks = $user->decks()->paginate();

        return $this->response->paginator($decks, new DeckTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();

        if (!$user->ability('admin', Permission::CREATE_DECKS)) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'public' => 'boolean',
        ]);

        $deck = $user->decks()->create([
            'name' => $request->get('name'),
            'public' => $request->get('public') ?? true,
        ]);

        // create fields
        if ($request->has('fields')) {
            $fields = $request->get('fields');
            foreach ($fields as $field) {
                $deck->fields()->create(['name' => $field]);
            }
        }

        return $this->response->item($deck, new DeckTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deck = Deck::find($id);

        if (!$deck) {
            abort(404);
        }

        $user = \Auth::user();

        if ($user->ability('admin', Permission::READ_DECKS) && $deck->user->id != $user->id) {
            abort(403);
        }

        return $this->response->item($deck, new DeckTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deck = Deck::find($id);

        if (!$deck) {
            abort(404);
        }

        $user = \Auth::user();

        if ($user->ability('admin', Permission::UPDATE_DECKS) && $deck->user->id != $user->id) {
            abort(403);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['name', 'public']));
        $deck->update($properties);

        // update tags
        if ($request->has('tags')) {
            $tags = $request->get('tags');
            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                $deck->tags()->attach($tag);
            }
        }

        // update groups
        if ($request->has('groups')) {
            $groups = $request->get('groups');
            foreach ($groups as $group) {
                $deck->groups()->attach(Group::find($group));
            }
        }

        return $this->response->item($deck, new DeckTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deck = Deck::find($id);

        if (!$deck) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_DECKS) && $deck->user->id != $user->id) {
            abort(403);
        }

        $deck->delete();

        return $this->response->noContent();
    }
}
