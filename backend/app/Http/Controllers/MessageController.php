<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class MessageController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'description' => 'required|max:255',
            'time_sent' => 'required|date_format:Y-m-d H:i:s',
            'event_id' => 'required|integer',
            'owner_id' => 'required|integer',
        ]);
    }

    public function comment(Request $request)
    {
        $messageData = $request->only('description', 'time_sent', 'owner_id', 'event_id');

        $owner = $messageData['owner_id'];
        $event = $messageData['event_id'];

        $eventuser = DB::table('eventuser')->where('user_id',$owner)->where('event_id',$event)->get();

        if(count($eventuser) != 0) {

            $validate = $this->validator($messageData);
            if ($validate->fails()) {
                return response($validate->errors(), 417);
            } else {
                Message::create($messageData);
                return response(['message accepted' => 'all parameters were accepted'], 200);
            }
        }
        else
        {
            return response(['message not accepted' => 'The pair {User, Event} is not found in the DB.'], 404);
        }

    }
}
