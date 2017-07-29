<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CardTransformer;
use App\Models\Card;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Deck;

class CardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();

        if (!$user->ability('admin', Permission::CREATE_CARDS)) {
            abort(403);
        }

        $this->validate($request, [
            'deck_id' => 'required',
        ]);

        // create the card
        $deck = Deck::find($request->get('deck_id'));

        if (!$deck) {
            abort(401);
        }

        $card = $deck->cards()->create([]);

        // fill the fields values
        $fields = $request->get('fields') ?? [];
        foreach ($fields as $id => $value) {
            $card->fields()->attach($id, ['value' => $value]);
        }

        return $this->response->item($card, new CardTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::find($id);

        if (!$card) {
            abort(404);
        }

        $user = \Auth::user();

        if ($user->ability('admin', Permission::READ_CARDS) && $card->deck->user->id !== $user->id) {
            abort(403);
        }

        return $this->response->item($card, new CardTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);

        if (!$card) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::UPDATE_CARDS) && $card->deck->user->id != $user->id) {
            abort(403);
        }

        // fill the fields values
        $fields = $request->get('fields');
        foreach ($fields as $id => $value) {
            $card->fields()->attach($id, ['value' => $value]);
        }

        return $this->response->item($card, new CardTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::find($id);

        if (!$card) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_CARDS) && $card->deck->user->id != $user->id) {
            abort(403);
        }

        $card->delete();

        return $this->response->noContent();
    }
}
