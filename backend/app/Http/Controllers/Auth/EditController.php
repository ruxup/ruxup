<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Image;

class EditController extends Controller
{
    // Open from database.
    public function getProfile()
    {
        try
        {
            if(!isset($_SERVER['HTTP_TOKEN']))
            {
                return response("token_not_set", 401);
            }
            if (! $user = JWTAuth::setToken($_SERVER['HTTP_TOKEN'])->authenticate())
            {
                return response("user_not_found", 404);
            }
        }
        catch (JWTException $exc)
        {
            // Wrong token
            return response('could_not_create_token', 500);
        }

        return response()->json(compact('token'));
    }

    // Upload to profile.
    public function postUpdateProfile(Request $request)
    {
        // Handle user upload of avatar


    }
}
