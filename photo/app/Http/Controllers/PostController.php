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
        $myPosts = DB::table('posts')
            ->select('posts.id as id',
                'posts.name_post as name_post',
                'posts.description as description',
                'posts.updated_at as date',
                'users.name as name_user',
                'users.id as user_id'
            )
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.user_id', '=', Auth::user()->id)
            ->orderBy('posts.updated_at', 'desc')
            ->paginate(25);


        $anyPosts = DB::table('posts')
            ->select('posts.id as id',
                'posts.name_post as name_post',
                'posts.description as description',
                'posts.updated_at as date',
                'users.name as name_user',
                'users.id as user_id'
            )
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.user_id', '<>', Auth::user()->id)
            ->orderBy('posts.updated_at', 'desc')
            ->paginate(25);

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
            'name_post' => 'required',
            'description' => 'required'
        ]);

        $post = new Post();
        $post->name_post = $request->name_post;
        $post->description = $request->description;
        $post->user_id = Auth::user()->id;
        $post->save();

        $user = User::find(Auth::user()->id);
        $user->score += 50;
        $user->save();

        return redirect('/home');
    }

    public function showPostUser($id)
    {
        $posts = DB::table('posts')
            ->select('posts.id as id',
                'posts.name_post as name_post',
                'posts.description as description',
                'posts.updated_at as date'
            )
            ->where('posts.user_id', '=', $id)
            ->orderBy('posts.updated_at', 'desc')
            ->paginate(50);
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
        DB::table('posts')
            ->where('id', $id)
            ->update(['name_post' => $request->name_post,
                'description' => $request->description]);

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
        DB::table('posts')->where('id', '=', $id)->delete();
        return redirect('/home');
    }
}
