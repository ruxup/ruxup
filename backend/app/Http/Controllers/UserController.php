<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use DateTime;

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

    public function joinEvent($userId, $eventId)
    {
        try {
            $user = User::findOrFail($userId);
            $event = Event::findOrFail($eventId);

            $event->users()->attach($user, array('joined_at' => new DateTime(), 'active' => 1));
            return response('User '. $user->name . ' has joined event ' . $event->name, 200);
        }
        catch (ModelNotFoundException $exception)
        {
            return response($exception->getModel() . ' not found', 404);
        }
        catch (QueryException $queryException)
        {
            return response('User already is a member of this event', 409);
        }

    }

    public function findEvent($location, $starttime, $category)
    {
        try {
           // $eventData = $request->only('location','start_time','category');

            $locationEvents=DB::table('events')->where('location',$location)->where('start_time',$starttime)->where('category',$category)->get();

            return response(json_encode($locationEvents), 200);
        } catch (ModelNotFoundException $exception) {
            return response("User_Not_Found", 404);
        }
    }
}
