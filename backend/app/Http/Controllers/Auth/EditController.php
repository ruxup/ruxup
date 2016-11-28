<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Image;
use Validator;
use Illuminate\Foundation\Auth\User;

class EditController extends Controller
{
    // Upload to profile.
    public function putUpdateProfile(Request $request, $id)
    {
        $userData = $request->only('name', 'email', 'password', 'nationality', 'bio', 'city', 'profile_pic', 'phone');

        $user = User::find($id);

        $user->name = (string)$userData['name'];
        $user->email = (string)$userData['email'];
        $user->password = (string)$userData['password'];
        $user->nationality = (string)$userData['nationality'];
        $user->bio = $userData['bio'];
        $user->city = (string)$userData['city'];
        $user->profile_pic = (string)$userData['profile_pic'];
        $user->phone = (string)$userData['phone'];

        $user->save();

        return response('Profile was successfully edited', 200);
    }
}
