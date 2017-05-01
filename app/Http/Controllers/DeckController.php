<?php

namespace App\Http\Controllers;

use App\Http\Transformers\DeckTransformer;
use App\Models\Deck;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class DeckController extends Controller
{
    public function index(JWTAuth $jwtAuth, Request $request)
    {
        $page = $request->input('page') ?: 1;
        $per_page = $request->input('per_page') ?: 25;

        $user = $jwtAuth->parseToken()->authenticate();
        $decks = $user->decks()
            ->with('cards.fields', 'fields')
            ->paginate($per_page, ['*'], 'page', $page);

        return $this->response->paginator($decks, new DeckTransformer);
    }

    public function show($id, JWTAuth $jwtAuth)
    {
        $deck = Deck::findOrFail($id);

        if(!$deck->is_public) {
            $user = $jwtAuth->parseToken()->authenticate();

            if($deck->owner->id !== $user->id) {
                abort(403);
            }
        }

        return $this->item($deck, new DeckTransformer);
    }
}
