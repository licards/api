<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CardTransformer;
use App\Models\Card;
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
        $this->validate($request, [
            'deck_id' => 'required',
        ]);

        // create the card
        $deck = Deck::findOrFail($request->get('deck_id'));
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

        if ($card->deck->user_id !== $user->id) {
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
        $card = Card::findOrFail($id);

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
        Card::findOrFail($id)->delete();

        return $this->response->noContent();
    }
}
