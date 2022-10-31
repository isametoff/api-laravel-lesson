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
        // dd($data['isAuth'] === "true" && User::where('login', $data['login'])->exists() === true);
        // dd($data['isAuth'] === "true", $data);
        $data = $data['isAuth'] === true && User::where('login', $data['login'])->exists() === true ? true : false;

        // $user = AuthResource::collection($data);
        // return ($data);

        return compact('data');
    }
}
