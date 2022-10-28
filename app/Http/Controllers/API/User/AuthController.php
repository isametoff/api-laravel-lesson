<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthUserRequest;
use App\Http\Resources\User\AuthResource;
use App\Models\User;

class AuthController extends Controller
{
    public function __invoke(AuthUserRequest $request)
    {
        $data = $request->validated();
        $data = User::where('login', $data['login'])->get();
        $user = AuthResource::collection($data);

        return compact('user');
    }
}
