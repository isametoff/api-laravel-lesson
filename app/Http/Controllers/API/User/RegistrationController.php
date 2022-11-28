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
        $created = User::where('email_token', $token)->value('updated_at');
        // dd($token);
        $now = Carbon::now();
        // dd($created->diff($now))->days;
        // $validToken = Carbon::parse($created)->floatDiffInMinutes(Carbon::now());
        $date = Carbon::parse($created);
        $validToken = $date->diffInMinutes($now);
        $user = User::where('email_token', $token)->first();
        dd(User::all()->last());
        if ($validToken == true) {
            $user->email_verified_at = now();
            $user->save();
            return view('emailconfirm');
        } else {
            return RegistrationController::repeatVerify($token);
        }
    }

    public function repeatVerify($token)
    {
        return "lll";
        $created = User::where('email_token', $token)->value('updated_at');
        $validToken = Carbon::parse($created)->floatDiffInMinutes(now()) < 1;

        $user = User::where('email_token', $token)
            ->update([
                'email_token' => Str::random(40),
            ]);
        dispatch(new SendVerificationEmail($user));
        return view('email.repeat_verify_account', ['user' => $user]);
    }
}
