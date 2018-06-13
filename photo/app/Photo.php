<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function like()
    {
        return $this->hasMany('App\Like', 'photo_id');
    }
}
