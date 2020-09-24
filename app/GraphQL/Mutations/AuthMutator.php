<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\AuthException;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthMutator
{
    public function login($_, array $args)
    {
        $this->validateLogin($args);
        $credentials = ['email' => $args['email'], 'password' => $args['password']];
        $guard = Auth::guard(config('sanctum.guard', 'web'));
        if (! $guard->attempt($credentials)) {
            $this->sendFailedLoginResponse();
        }

        $user = $guard->user();
        $token = $user->createToken('mobile-token');

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token->plainTextToken
        ];
    }

    protected function validateLogin($args)
    {
        $validator = Validator::make($args, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException('The given data was invalid', $validator->errors()->messages());
        }
    }

    protected function sendFailedLoginResponse()
    {
        throw new AuthException('The given data doesn\'t match our records');
    }
}
