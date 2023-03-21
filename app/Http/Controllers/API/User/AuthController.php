<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthUserRequest;
use App\Http\Resources\User\AuthResource;
use App\Models\User;
use App\Models\UserActiviness;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($request)
    {
        $data = $request;
        $browser = 'Chrome';
        $system = 'Windows';
        if (strripos($request->header('sec-ch-ua'), 'Chrome')) {
            $browser = 'Chrome';
        } elseif (strripos($request->header('sec-ch-ua'), 'Mozilla')) {
            $browser = 'Mozilla';
        } elseif (strripos($request->header('sec-ch-ua'), 'Yandex')) {
            $browser = 'Yandex';
        } elseif (strripos($request->header('sec-ch-ua'), 'Safari')) {
            $browser = 'Safari';
        } elseif (strripos($request->header('sec-ch-ua'), 'Opera')) {
            $browser = 'Opera';
        } elseif (strripos($request->header('sec-ch-ua'), 'Edge')) {
            $browser = 'Edge';
        }
        if (strripos($request->header('x-forwarded-for'), 'Windows')) {
            $system = 'Windows';
        } elseif (strripos($request->header('sec-ch-ua'), 'MacOs')) {
            $system = 'MacOs';
        } elseif (strripos($request->header('sec-ch-ua'), 'Ubuntu')) {
            $system = 'Ubuntu';
        } elseif (strripos($request->header('sec-ch-ua'), 'Linux')) {
            $system = 'Linux';
        }
        // return $request->header();
        $credentials = ["login" => $data["login"], "password" => $data["password"]];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['errors' => ['error' => ['Incorrect login or password']]], 401);
        }
        $ip = $request->header('x-forwarded-for') ? $request->header('x-forwarded-for') : '';
        UserActiviness::create([
            'user_id' => auth()->id(),
            'ip' => $ip,
            'browser' => $browser . ' ' . 'on' . ' ' . $system,
        ]);
        return $this->respondWithToken($token);
    }

    public function me(Request $request)
    {
        // if (User::where('id', auth()->id())->value('ip') != $request->header('x-forwarded-for')) {
        //     User::where('id', auth()->id())->update(['ip' => null]);
        //     $this->logout();
        // }
        return AuthResource::make(User::where('id', auth()->id())->first());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out', 'logout' => true]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()
        ]);
    }
}
