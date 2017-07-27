<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CategoryTransformer;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            // can't delete the root category
            abort(401);
        }

        Category::findOrFail($id)->delete();

        return $this->response->noContent();
    }
}
