<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Image;
use Validator;
use Illuminate\Foundation\Auth\User;

class EditController extends Controller
{
    // Upload to profile.
    public function putUpdateProfile(Request $request, $id)
    {
        $userData = $request->only('name', 'email', 'password', 'nationality', 'bio', 'city', 'profile_pic', 'phone');

        $user = User::find($id);

        $image = $request->file('image');
        $upload = 'img/posts/';
        $filename = time().$image->getClientOriginalName();
        $path = move_uploaded_file($image->getPathname(), $upload. $filename);

        $user->name = (string)$userData['name'];
        $user->email = (string)$userData['email'];
        $user->password = (string)$userData['password'];
        $user->nationality = (string)$userData['nationality'];
        $user->bio = $userData['bio'];
        $user->city = (string)$userData['city'];
        $user->profile_pic = $filename;
        $user->phone = (string)$userData['phone'];

        $user->save();

        return response('Profile was successfully edited', 200);
    }





    //Create post
/*
$image = $request->file('image');
$upload = 'img/posts/';
$filename = time().$image->getClientOriginalName();
$path = move_uploaded_file($image->getPathname(), $upload. $filename);

$post = new Post();
$post->category_id = $request->category_id;
$post->title = $request->title;
$post->author = $request->author;
$post->image = $filename;
$post->short_desc = $request->short_desc;
$post->description = $request->description;
$post->save();

Session::flash('post_create', 'New post is Created');

return redirect('post/create');
*/
}
