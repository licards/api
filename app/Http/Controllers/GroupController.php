<?php

namespace App\Http\Controllers;

use App\Http\Transformers\GroupTransformer;
use App\Models\Group;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class GroupController extends Controller
{
    public function index(JWTAuth $jwtAuth)
    {
        $user = $jwtAuth->parseToken()->authenticate();
        $groups = $user->groups;

        return $this->response->collection($groups, new GroupTransformer);
    }

    public function show($id, JWTAuth $jwtAuth)
    {
        $group = Group::find($id);

        if(!$group) {
            abort(404);
        }

        $user = $jwtAuth->parseToken()->authenticate();
        
        if($group->owner->id !== $user->id) {
            abort(403);
        }

        return $this->item($group, new GroupTransformer);
    }
}

