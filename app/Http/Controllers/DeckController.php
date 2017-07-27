<?php

namespace App\Http\Controllers;

use App\Http\Transformers\DeckTransformer;
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
        $decks = Deck::where(['user_id' => $user->id])->paginate();

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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $deck = \Auth::user()->decks()->create(['name' => $request->get('name')]);

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
        $user = \Auth::user();
        $deck = Deck::find($id);

        if (!$deck) {
            abort(404);
        }

        if ($deck->user_id !== $user->id) {
            abort(403);
        }

        return $this->response->item($deck, new DeckTransformer);
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
        $deck = Deck::find($id);

        if (!$deck) {
            abort(404);
        }

        if ($deck->user_id !== \Auth::user()->id) {
            abort(403);
        }

        // update default properties
        $deck->update($request->intersect(['name']));

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
        Deck::findOrFail($id)->delete();

        return $this->response->noContent();
    }
}
