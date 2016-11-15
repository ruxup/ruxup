<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;

class InterestsController extends Controller
{
    public function index()
    {
        $interests = Interest::all();
        return view('interests.index')->with('interests', $interests);
    }
}
