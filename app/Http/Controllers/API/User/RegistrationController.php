<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailTokenRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserIdRequest;
use App\Jobs\SendVerificationEmail;
use App\Models\User;
use App\Models\UserPasswords;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function create(StoreUserRequest $request)
    {
        $data = $request->validated();
        if ($data['register'] === true) {
            $user = User::create([
                'login' => $data['login'],
                'password' => Hash::make($data['password']),
                'telegram' => $data['telegram'],
            ]);
            UserPasswords::create([
                'user_id' => $user->id,
                'password' => $user->password,
            ]);
        }
        $data = User::where('login', $data['login'])
            ->where('telegram', $data['telegram'])->exists() ?? $data['register'] === true ?? false;

        return compact('data');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailTokenRequest $request)
    {
        $data = $request->validated();
        $token = $data['email_token'];
        $validToken = User::where('email_token', $token)->exists();
        if (!$validToken) {
            return 'Link is invalid';
        }
        if (!User::where('email_token', $token)->value('email_verified_at')) {
            $created = User::where('email_token', $token)->value('updated_at');
            $now = Carbon::now();
            $date = Carbon::parse($created);
            $validToken = $date->diffInMinutes($now) < 1;
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

    public function repeatVerify(UserIdRequest $request)
    {
        $data = $request->validated();
        $userId = $data['userId'];
        User::where('id', $userId)
            ->update([
                'email_token' => Str::random(30),
            ]);
        $user = User::where('id', $userId)->first();
        dispatch(new SendVerificationEmail($user));
        return view('returnemailconfirm');
    }
}
