<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthUserRequest;

class AuthViability extends Controller
{
    public function __invoke(AuthUserRequest $request, AuthController $authController)
    {
        return $authController->login($request);
    }
}