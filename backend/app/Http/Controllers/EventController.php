<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Debug\Exception\FatalErrorException;
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
            $ownerId = $event->owner_id;
            $owner = User::find($ownerId);
            if (is_null($owner)) {
                return response('User with id: ' . $ownerId . ' not found.', 404);
            }
            $this->updatePivotUserEvent($event, $owner);
            return response('Event created successfully', 201);
        }
    }

    public function leaveEvent($userId, $eventId)
    {
        try {
            $elementToRemove = $this->checkIfUserIsMemberOfEvent($userId, $eventId);
            if (!is_null($elementToRemove)) {
                $this->removeUserFromEvent($userId, $eventId);
            }
            else
            {
                return response('User with id ' . $userId . ' is not member of event with id ' . $eventId);
            }

            return response('User with id ' . $userId . ' left event with id ' . $eventId, 201);

        } catch (ModelNotFoundException $exception) {
            return response('Event_not_found', 404);
        } catch (FatalErrorException $exception) {
            return response('Event_not_found', 404);
        } catch (QueryException $exception) {
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

    public function updateEvent(Request $request)
    {
        $id = $request->only('id');

        $event = Event::whereId($id)->first();

        try {
            $name = $request->get('name');
            if ($name != '') {
                $event->name = $name;
            }
            $location = $request->get('location');
            if ($location != '') {
                $event->location = $location;
            }
            $start_time = $request->get('start_time');
            if ($start_time != '') {
                $event->start_time = $start_time;
            }
            $end_time = $request->get('end_time');
            if ($end_time != '') {
                $event->end_time = $end_time;
            }
            $description = $request->get('description');
            if ($description != '') {
                $event->description = $description;
            }
            $category = $request->get('category');
            if ($category != '') {
                $event->category = $category;
            }

            $event->save();
        } catch (QueryException $e) {
            return response($e->getMessage(), 400);
        }
        return response("update_event_success", 200);
    }

    public function getAllEvents($column, $orderType)
    {
        try {
            if ($orderType != 'DESC' && $orderType != 'ASC') {
                return response('wrong orderType parameter', 406);
            }

            if (Schema::hasColumn('events', $column)) {
                $events = Event::orderBy($column, $orderType)->get();
                if ($events->count() != 0) {
                    return response($events, 200);
                }
                return response('There are no events', 404);
            } else {
                return response('The column specified does not exist within events table', 406);
            }
        } catch (QueryException $e) {
            return response($e->getMessage(), 400);
        }
    }

    private function updatePivotUserEvent(Event $event, User $owner)
    {
        $event->users()->attach($owner, array('joined_at' => new DateTime(), 'active' => 1));
    }

    private function checkIfUserIsMemberOfEvent($userId, $eventId)
    {
        return DB::table(config('constants.eventuser_table'))->where('user_id', '=', $userId)
            ->where('event_id', '=', $eventId)->first();
    }

    private function removeUserFromEvent($userId, $eventId)
    {
        DB::table(config('constants.eventuser_table'))->where('user_id', '=', $userId)
            ->where('event_id', '=', $eventId)->delete();
    }

}
