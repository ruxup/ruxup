<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getEvents($id)
    {
        try {
            $user = User::findOrFail($id);
            return response(json_encode($user->events), 200);
        } catch (ModelNotFoundException $exception) {
            return response("User_Not_Found", 404);
        }
    }

    public function getEventsWhereOwner($id)
    {
        try {
            User::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            return response("User_Not_Found", 404);
        }
        return response(DB::table('events')->where('owner_id', $id)->get(), 200);

    }
}
