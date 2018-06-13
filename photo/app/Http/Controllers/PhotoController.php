<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        if (isset($request) && isset($post_id)) {
            $photo = new Photo();
            $file = $request->file('path');
            $filename = trim($file->getClientOriginalName());
            $photo->path = $filename;
            $photo->name_photo = $request->name_post;
            $photo->post_id = $post_id;
            $destinationPath = public_path() . '\photos';
            $request->file('path')->move($destinationPath, $filename);
            $photo->save();

            $user = User::find(Auth::user()->id);
            $user->raw_score += 2;
            $user->save();

            return redirect('/photo/show' . $post_id);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photos = Photo::where('post_id', $id)
            ->groupBy('id')
            ->orderBy('updated_at', 'desc')
            ->paginate(25);

        $post = Post::find($id);

        $user = User::find($post->user_id);

        return view('photos.show')->with(['photos' => $photos, 'post' => $post, 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $post_id)
    {
        if (isset($id) && isset($post_id)) {
            $photo = Photo::find($id);
            $photo->delete();

            $user = User::find(Auth::user()->id);
            if ($user->raw_score >= 2)
                $user->raw_score -= 2;
            else
                $user->raw_score = 0;
            $user->save();

            return redirect('/photo/show' . $post_id);
        }
    }
}
