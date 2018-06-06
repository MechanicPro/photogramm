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
            $user->score += 2;
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
        $photos = DB::table('photos')
            ->select('photos.id as id',
                'photos.name_photo as name_photo',
                'photos.path as path',
                'photos.updated_at as date',
                DB::raw('SUM(likes.like_ph) as like_ph'),
                DB::raw('SUM(likes.dislike_ph) as dislike_ph')
            )
            ->leftJoin('likes', 'likes.photo_id', '=', 'photos.id')
            ->where('photos.post_id', '=', $id)
            ->orderBy('photos.updated_at', 'desc')
            ->groupBy('photos.id')
            ->paginate(50);

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
            DB::table('photos')->where('id', '=', $id)->delete();

            $user = User::find(Auth::user()->id);
            if ($user->score >= 2)
                $user->score -= 2;
            else
                $user->score = 0;
            $user->save();

            return redirect('/photo/show' . $post_id);
        }
    }
}
