<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Image;

class EditController extends Controller
{
    protected function validator(array $data)
    {
        $messages = [
            'email.unique' => 'The email has already been taken',
        ];

        return Validator::make($data, [
            'name' => 'required|max:255|unique:events',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'nationality' => 'max:255',
            'bio'=> 'max:5000',
            'city' => 'max:255',
            'profile_pic' => 'max:255',
            'cover_pic' => 'max:255',
            'phone' => 'max:255',
            'update_at' => 'date_format:Y-m-d H:i:s'
        ], $messages);
    }

    // Upload to profile.
    public function putUpdateProfile(Request $request)
    {
        $userData = $request->only('name', 'email', 'password', 'nationality', 'bio', 'city', 'profile_pic', 'phone', 'update_at');

        $validate = $this->validator($userData);
        if($validate->fails())
        {
            return response($validate->errors()->all(), 417);
        }
        else
        {
            User::update($userData);
            return response('Profile was successfully edited', 201);
        }


    }
}
