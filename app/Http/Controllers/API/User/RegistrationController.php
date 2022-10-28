<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function __invoke(StoreUserRequest $request)
    {
        $data = $request->validated();
        User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        $data = User::where('email', $data['email'])->where('login', $data['login'])->exists() ?? false;

        return compact('data');
    }
}