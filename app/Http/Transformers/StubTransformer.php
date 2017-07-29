<?php

namespace App\Http\Transformers;

use App\Models\Stub;
use League\Fractal\TransformerAbstract;

class StubTransformer extends TransformerAbstract
{
    public function transform(Stub $stub)
    {
        return $stub->toArray();
    }
}
