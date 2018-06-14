<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function counts($id)
    {
        $counts = [];
        $like = Like::where('photo_id', $id)->get();
        $counts['like'] = $like->sum('like_ph');
        $counts['dislike'] = $like->sum('dislike_ph');

        return $counts;
    }

    public function like($id, $user_id, $post_id)
    {
        $isUser = false;

        $like = Like::where('likes.photo_id', $id)->get();

        if (count($like) > 0) {
            foreach ($like as $i) {
                if ($i->user_id != $user_id) {
                    $isUser = false;
                } else {
                    $isUser = true;
                    break;
                }
            }

            if ($isUser) {
                Like::where([
                    ['user_id', '=', $user_id],
                    ['photo_id', '=', $id],
                ])->delete();

                $user = User::find($user_id);
                if ($user->raw_score >= 1)
                    $user->raw_score -= 1;
                else
                    $user->raw_score = 0;
                $user->save();
            } else {
                $like = new Like();
                $like->like_ph = 1;
                $like->dislike_ph = 0;
                $like->photo_id = $id;
                $like->user_id = $user_id;
                $like->save();

                $user = User::find($user_id);
                $user->raw_score += 1;
                $user->save();
            }
        } else {
            $like = new Like();
            $like->like_ph = 1;
            $like->dislike_ph = 0;
            $like->photo_id = $id;
            $like->user_id = $user_id;
            $like->save();

            $user = User::find($user_id);
            $user->raw_score += 1;
            $user->save();
        }

        return $this->counts($id);
    }

    public function dislike($id, $user_id, $post_id)
    {
        $isUser = false;

        $like = Like::where('likes.photo_id', $id)->get();

        if (count($like) > 0) {
            foreach ($like as $i) {
                if ($i->user_id != $user_id) {
                    $isUser = false;
                } else {
                    $isUser = true;
                    break;
                }
            }

            if ($isUser) {
                Like::where([
                    ['user_id', '=', $user_id],
                    ['photo_id', '=', $id],
                ])->delete();
            } else {
                $like = new Like();
                $like->like_ph = 0;
                $like->dislike_ph = 1;
                $like->photo_id = $id;
                $like->user_id = $user_id;
                $like->save();
            }
        } else {
            $like = new Like();
            $like->like_ph = 0;
            $like->dislike_ph = 1;
            $like->photo_id = $id;
            $like->user_id = $user_id;
            $like->save();
        }

        return $this->counts($id);
    }
}
