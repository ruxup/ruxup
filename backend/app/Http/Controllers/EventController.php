<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\EventUser;
use App\Event;
use App\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

class EventController extends Controller
{
    protected function validator(array $data)
    {
        $messages = [
            'name.unique' => 'The event name has already been taken',
        ];

        return Validator::make($data, [
            'name' => 'required|max:255|unique:events',
            'location' => 'required|max:255',
            'start_time' => 'date_format:Y-m-d H:i:s',
            'end_time' => 'date_format:Y-m-d H:i:s',
            'category' => 'required|max:255',
            'description' => 'max:5000',
            'image' => 'max:255',
            'owner_id' => 'required|integer'
        ], $messages);
    }

    public function create(Request $request)
    {
        $eventData = $request->only('name', 'location', 'start_time', 'end_time', 'category', 'description', 'image', 'owner_id');

        $validate = $this->validator($eventData);
        if ($validate->fails()) {
            return response($validate->errors()->all(), 417);
        } else {
            $event = Event::create($eventData);
            $owner = User::find($event->owner_id);
            //Update the pivot table as well
            $event->users()->attach($owner, array('joined_at' => new DateTime(), 'active' => 1));
            return response('Event created successfully', 201);
        }
    }

    public function deleteLeaveEvent($userId,$eventId)
    {
        try {
            $eventUser=DB::table('eventuser')->where('user_id', '=', $userId)
                ->where('event_id', '=', $eventId)
                ->first();

            $eventUser->delete();

            return response('Event deleted successfully', 201);

        } catch (ModelNotFoundException $exception) {
            return response('Event_not_found', 404);
        } catch(FatalErrorException $exception) {
            return response('Event_not_found', 404);
        } catch (QueryException $exception){
        return response('Event_not_found', 404);
        }
    }

    public function getUsers($id)
    {
        try {
            $event = Event::findOrFail($id);
            return response(json_encode($event->users), 200);
        } catch (ModelNotFoundException $exception) {
            return response('Event_not_found', 404);
        }


    }
}
