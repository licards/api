<?php

namespace App\Http\Controllers;

use App\Http\Transformers\GroupTransformer;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $groups = Group::where(['user_id' => $user->id])->get();

        return $this->response->collection($groups, new GroupTransformer());
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

        if (!$user->ability('admin', Permission::CREATE_GROUPS)) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
        ]);

        // create the card
        $group = $user->groups()->create(['name' => $request->get('name')]);

        return $this->response->item($group, new GroupTransformer());
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

        if (!$user->ability('admin', Permission::UPDATE_GROUPS)) {
            abort(403);
        }

        $group = Group::find($id);

        if (!$group) {
            abort(404);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['name']));
        $group->update($properties);

        return $this->response->item($group, new GroupTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_GROUPS) && $group->user->id != $user->id) {
            abort(403);
        }

        $group->delete();

        return $this->response->noContent();
    }
}
