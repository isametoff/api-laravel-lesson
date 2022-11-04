<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function __invoke(StoreUserRequest $request)
    {
        $data = $request->validated();
        if ($data['register'] === true) {
            User::create([
                'login' => $data['login'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }
        $data = User::where('email', $data['email'])->where('login', $data['login'])
        ->exists() ?? $data['register'] === true ?? false;

        return compact('data');
    }
}
