<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

trait UserMethods
{

    public static function loginRules()
    {
        return [
            'email' => 'email|required',
            'password' => 'required'
        ];
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function withToken()
    {
        return $this->makeVisible(['api_token']);
    }
}
