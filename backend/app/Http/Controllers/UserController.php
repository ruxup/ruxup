<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventUser;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
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
        } catch (ModelNotFoundException $e) {
            return response("User_Not_Found", 404);
        }
        $arrayEvents = DB::table(config('constants.events_table'))->where('owner_id', $id)->get();
        if (count($arrayEvents) == 0) {
            return response("User is not an owner", 404);
        }
        return response(json_encode($arrayEvents), 200);

    }

    public function joinEvent($userId, $eventId)
    {
        try {
            $user = User::findOrFail($userId);
            $event = Event::findOrFail($eventId);

            $event->users()->attach($user, array('joined_at' => new DateTime(), 'active' => 1));
            return response('User ' . $user->name . ' has joined event ' . $event->name, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getModel() . ' not found', 404);
        } catch (QueryException $queryException) {
            return response('User already is a member of this event', 409);
        }

    }

    public function findEvent(Request $request)
    {
        $searchType = $request->input('type');
        $locationEvents = $this->getEventsByCriteria($request, $searchType);
        if (count($locationEvents) != 0) {
            return response(json_encode($locationEvents), 200);
        } else {
            return response("No events found. Please try again!", 404);
        }
    }

    public function removeProfile($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            EventUser::where('user_id', $id)->delete();
            return response("User: " . $user->name . " has been removed", 200);
        } catch (ModelNotFoundException $exception) {
            return response("User is not active", 404);
        }
    }

    public function restoreProfile($id)
    {
        try {
            User::withTrashed()
                ->where('id', $id)
                ->restore();
            EventUser::where('user_id', $id)->restore();
            $user = User::findOrFail($id);
            return response("User: " . $user->name . " has been restored", 200);
        } catch (\ErrorException $exception) {
            return response("User is active.", 404);
        }
        catch (ModelNotFoundException $exception) {
            return response("User not found", 404);
        }
    }

    private function getEventsByCriteria(Request $request, $searchType)
    {
        $location = $request->input('location');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $category = $request->input('category');
        switch ($searchType) {
            case 'time':
                return DB::table(config('constants.events_table'))->whereBetween('start_time', [$startTime, $endTime])->get();
                break;
            case 'location':
                return DB::table(config('constants.events_table'))->where('location', $location)->get();
                break;
            case 'category':
                return DB::table(config('constants.events_table'))->where('category', $category)->get();
            default:
                return DB::table(config('constants.events_table'))->where('location', $location)->whereBetween('start_time', [$startTime, $endTime])->where('category', $category)->get();
                break;
        }
    }

    public function rate(Request $request)
    {
        try {
            $rating = $request->all();
            Rating::create(rating);

            return response('User ' . $rating->rater_id . ' rated ' . $rating->ratee_id . ' with ' . $rating->star . ' stars.', 200);
            //return response('Success!', 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getModel() . ' not found', 404);
        } catch (QueryException $queryException) {
            return response('Query error', 409);
        }
    }
}
