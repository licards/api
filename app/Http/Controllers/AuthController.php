<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request, JWTAuth $jwtAuth)
    {
        $credentials = $request->only(['email', 'password']);

        $token = $jwtAuth->attempt($credentials);

        if (!$token) {
            throw new AccessDeniedHttpException('Provided credentials are not valid.');
        }

        return $this->response->array(null)->withHeader('Authorization', 'Bearer ' . $token);
    }

    public function register(Request $request, JWTAuth $jwtAuth)
    {
        if(User::where(['email' => $request->input('email')])->first()) {
            throw new ConflictHttpException('User with provided e-mail already exists.');
        }

        try {
            $user = new User($request->all());
            $user->save();
        } catch (\Exception $e) {
            throw new HttpException(500);
        }

        $token = $jwtAuth->fromUser($user);

        return $this->response->array(['success' => true, 'token' => $token]);
    }
}
