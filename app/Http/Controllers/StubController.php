<?php

namespace App\Http\Controllers;

use App\Http\Transformers\StubTransformer;
use App\Models\Permission;
use App\Models\Stub;
use Illuminate\Http\Request;

class StubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $stubs = Stub::where(['user_id' => $user->id])->paginate();

        return $this->response->paginator($stubs, new StubTransformer());
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

        if (!$user->ability('admin', Permission::CREATE_STUBS)) {
            abort(403);
        }

        $this->validate($request, [
            'value' => 'required',
        ]);

        // create the card
        $stub = $user->stubs()->create(['value' => $request->get('value')]);

        return $this->response->item($stub, new StubTransformer());
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
        $stub = Stub::find($id);

        if (!$stub) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::UPDATE_STUBS) && $stub->user->id != $user->id) {
            abort(403);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['value']));
        $stub->update($properties);

        return $this->response->item($stub, new StubTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stub = Stub::find($id);

        if (!$stub) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_STUBS) && $stub->user->id != $user->id) {
            abort(403);
        }

        $stub->delete();

        return $this->response->noContent();
    }
}
