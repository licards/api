<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return $resource;
    }
}