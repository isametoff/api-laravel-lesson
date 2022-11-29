<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Jobs\SendVerificationEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function create(StoreUserRequest $request)
    {
        $data = $request->validated();
        if ($data['register'] === true) {
            event(new Registered(
                $user = User::create([
                    'login' => $data['login'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'email_token' => Str::random(30),
                    // 'email_token' => base64_encode($data['email']),
                ])
            ));
            dispatch(new SendVerificationEmail($user));
        }
        $data = User::where('email', $data['email'])->where('login', $data['login'])
            ->exists() ?? $data['register'] === true ?? false;

        return compact('data');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $validToken = User::where('email_token', $token)->exists();
        if (!$validToken) {
            return 'Link is invalid';
        }
        if (!User::where('email_token', $token)->value('email_verified_at')) {
            $created = User::where('email_token', $token)->value('updated_at');
            $now = Carbon::now();
            $date = Carbon::parse($created);
            $validToken = $date->diffInMinutes($now) > 1;
            $user = User::where('email_token', $token)->first();
            $userId = User::where('email_token', $token)->value('id');
            if ($validToken === true) {
                $user->email_verified_at = now();
                $user->save();
                return view('emailconfirm');
            } else {
                return view('email.repeat_verify_account', compact('userId'));
            }
        }
        return view('emailconfirm');
    }

    public function repeatVerify(int $userId)
    {
        User::where('id', $userId)
            ->update([
                'email_token' => Str::random(30),
            ]);
        $user = User::where('id', $userId)->first();
        dispatch(new SendVerificationEmail($user));
        return view('returnemailconfirm');
    }
}
