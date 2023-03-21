<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Models\User;
use App\Models\UserPasswords;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{
    public function index(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        if (Hash::check($data['password'], auth()->user()->password) === false) {
            return response()->json(['errors' => ['password' => ['The real password is not correct.']]], 422);
        } else if ($this->checkBeforePassword($data['new_password']) === true) {
            return response()->json(['errors' => ['new_password' => ['This password has already been used.']]], 422);
        }
        if (Hash::check($data['password'], auth()->user()->password) === true) {

            User::where('id', auth()->id())->update(['password' => Hash::make($data['new_password'])]);
            UserPasswords::create([
                'user_id' => auth()->user()->id,
                'password' => Hash::make($data['new_password']),
            ]);
            return Hash::check($data['new_password'], User::where('id', auth()->id())->value('password')) === true ? true : false;
        }
    }
    static function checkBeforePassword($password): bool
    {
        foreach (UserPasswords::where('user_id', auth()->id())->get() as $key) {
            if (Hash::check($password, $key->password) === true) {
                return true;
            };
        }
        return false;
    }
}
