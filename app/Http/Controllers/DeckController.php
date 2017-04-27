<?php

namespace App\Http\Controllers;

use App\Http\Transformers\DeckTransformer;
use App\Models\Deck;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class DeckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param JWTAuth $jwtAuth
     * @return \Illuminate\Http\Response
     */
    public function index(JWTAuth $jwtAuth)
    {
        $user = $jwtAuth->parseToken()->authenticate();
        $decks = $user->decks()
            ->with('cards.fields', 'fields')
            ->paginate();

        return $this->response->paginator($decks, new DeckTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param JWTAuth $jwtAuth
     * @return \Illuminate\Http\Response
     */
    public function show($id, JWTAuth $jwtAuth)
    {
        $deck = Deck::find($id);

        if(!$deck->is_public) {
            $user = $jwtAuth->parseToken()->authenticate();

            if($deck->owner->id !== $user->id) {
                abort(403);
            }
        }

        return $this->item($deck, new DeckTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
