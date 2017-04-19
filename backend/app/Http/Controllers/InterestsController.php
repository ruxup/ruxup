<?php

namespace App\Http\Controllers;

use App\Interest;
use App\InterestUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InterestsController extends Controller
{
    public function delete($userId, $interestId)
    {
        $interest = InterestUser::withTrashed()->where('user_id', $userId)->where('interest_id', $interestId)->first();
        if (is_null($interest)) {
            return response('(user,interest) pair do not match', 404);
        }
        InterestUser::withTrashed()->where('user_id', $userId)->where('interest_id', $interestId)->forceDelete();
        return response("Interest has been removed", 200);
    }
}
