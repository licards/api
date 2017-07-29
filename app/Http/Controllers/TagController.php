<?php

namespace App\Http\Controllers;

use App\Http\Transformers\TagTransformer;
use App\Models\Permission;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
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

        if (!$user->ability('admin', Permission::CREATE_TAGS)) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
        ]);

        // create the tag
        $tag = Tag::firstOrCreate(['name' => $request->get('name')]);

        return $this->response->item($tag, new TagTransformer());
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
        $user = \Auth::user();

        if (!$user->ability('admin', Permission::UPDATE_TAGS)) {
            abort(403);
        }

        $tag = Tag::find($id);

        if (!$tag) {
            abort(404);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['name']));
        $tag->update($properties);

        return $this->response->item($tag, new TagTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_TAGS)) {
            abort(403);
        };

        $tag->delete();

        return $this->response->noContent();
    }
}
