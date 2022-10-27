<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class RegistrationController extends Controller
{
    public function __invoke(StoreUserRequest $request)
    {
        $data = $request->validated();

        return $data;
    }
}