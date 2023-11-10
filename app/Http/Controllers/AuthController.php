<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\ApiValidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = ApiValidate::login($request, User::class);
        if (Auth::guard('web')->attempt($credentials)) {
            $user = User::find(Auth::guard('web')->user()->id);
            return Api::setResponse('user', $user->withToken());
        } else {
            return Api::setError('Invalid credentials');
        }
    }
}
