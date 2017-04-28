<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->response->collection(Category::all(), new CategoryTransformer);
    }

    public function show($id)
    {
        return $this->response->item(Category::findOrFail($id), new CategoryTransformer);
    }
}
