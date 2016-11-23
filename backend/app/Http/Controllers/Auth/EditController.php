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

        }
        catch()
        {

        }

         return response()->json(compact('token'));
    }

    // Run composer require intervention/image
    public function postUpdateAvatar(Request $request)
    {
        // Handle user upload of avatar

    }

    // Upload to profile
    public function postUpdateProfile(Request $request)
    {
        // Handle user upload of avatar

    }
}
