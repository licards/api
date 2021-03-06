<?php

namespace App\Http\Controllers;

use App\Http\Transformers\FieldTransformer;
use App\Models\Field;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Deck;

class FieldController extends Controller
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

        if (!$user->ability('admin', Permission::CREATE_FIELDS)) {
            abort(403);
        }

        $this->validate($request, [
            'deck_id' => 'required',
            'name' => 'required',
        ]);

        $deck = Deck::findOrFail($request->get('deck_id'));
        $field = $deck->fields()->create(['name' => $request->get('name')]);

        return $this->response->item($field, new FieldTransformer());
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
        $field = Field::find($id);

        if (!$field) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::UPDATE_FIELDS) && $field->deck->user->id != $user->id) {
            abort(403);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['name']));
        $field->update($properties);

        return $this->response->item($field, new FieldTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::find($id);

        if (!$field) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_FIELDS) && $field->deck->user->id != $user->id) {
            abort(403);
        }

        $field->delete();

        return $this->response->noContent();
    }
}
