<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myPosts = Post::where('user_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(25);
        $anyPosts = Post::where('user_id', '<>', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(25);

        return view('home')->with(['myPosts' => $myPosts, 'anyPosts' => $anyPosts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_post' => 'required|max:50',
            'description' => 'required'
        ]);

        $post = new Post();
        $post->name_post = $request->name_post;
        $post->description = $request->description;
        $post->user_id = Auth::user()->id;
        $post->save();

        $user = User::find(Auth::user()->id);
        $user->raw_score += 50;
        $user->save();

        return redirect('/home');
    }

    public function showPostUser($id)
    {
        $posts = Post::where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(50);
        $user = User::find($id);

        return view('posts.show')->with(['posts' => $posts, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_post' => 'required|max:50',
            'description' => 'required'
        ]);

        $post = Post::find($id);
        $post->name_post = $request->name_post;
        $post->description = $request->description;
        $post->save();

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect('/home');
    }
}
