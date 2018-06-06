@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Фотографии ленты {{$post->name_post}} пользователя
                        <a href="/post/show/user{{$user->id}}"><b>{{$user->name}}</b></a>
                        <span class="badge badge-pill badge-info">{{count($photos)}}</span></div>
                    <a href="/photo/create{{$post->id}}">
                        <button type="button"
                                class="btn btn-outline-primary">Добавить новую фотографию
                        </button>
                    </a>
                    @extends('layouts.error')
                    @if (count($photos) > 0)
                        @foreach ($photos as $key => $photo)
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-primary">{{$photo->name_photo}}</li>
                                    <li class="list-group-item list-group-item-success"><img
                                                src="{{'/photos/' . $photo->path}}"
                                                class="img-thumbnail"
                                                alt="{{$photo->name_photo}}">
                                    </li>
                                </ul>
                                <div class="col-md-8">
                                    <span class="badge badge-pill badge-secondary">Дата публикации: <b>{{$photo->date}}</b></span>
                                    <a href="/photo/like/{{$photo -> id}}/{{Auth::user()->id}}/{{$post->id}}"
                                       class="badge badge-pill badge-success">like {{$photo->like_ph}}</a>
                                    <a href="/photo/dislike/{{$photo -> id}}/{{Auth::user()->id}}/{{$post->id}}"
                                       class="badge badge-pill badge-danger">dislike {{$photo->dislike_ph}}</a>
                                </div>
                                @if (Auth::user()->id == $user->id)
                                    <div class="col-md-8">
                                        <a class="badge badge-danger"
                                           href="/photo/destroy/{{$photo -> id}}/{{$post->id}}">Удалить
                                            фотографию</a>
                                    </div>
                                @endif
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <span class="badge badge-pill badge-warning">Фотографий пока нет...</span>
                    @endif

                </div>
                <?php echo $photos->render(); ?>
            </div>
        </div>
    </div>
@endsection
@endauth
