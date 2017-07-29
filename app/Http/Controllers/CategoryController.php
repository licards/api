<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CategoryTransformer;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // we assume that the first category is the root category
        return $this->response->item(Category::first(), new CategoryTransformer());
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

        if (!$user->ability('admin', Permission::CREATE_CATEGORIES)) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'parent_id' => 'required',
        ]);

        $category = Category::findOrFail($request->get('parent_id'))->children()->create(['name' => $request->get('name')]);

        return $this->response->item($category, new CategoryTransformer());
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

        if (!$user->ability('admin', Permission::READ_CATEGORIES)) {
            abort(403);
        }

        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        return $this->response->item($category, new CategoryTransformer());
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
        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::UPDATE_CATEGORIES)) {
            abort(403);
        }

        // update properties
        $properties = array_intersect_key($request->all(), array_flip(['name']));
        $category->update($properties);

        return $this->response->item($category, new CategoryTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        $user = \Auth::user();

        if (!$user->ability('admin', Permission::DELETE_CATEGORIES)) {
            abort(403);
        }

        $rootCategory = Category::where(['parent_id' => null])->first();

        if (!$rootCategory || $id == $rootCategory->id) {
            // can't delete the root category
            abort(401);
        }

        $category->delete();

        return $this->response->noContent();
    }
}
