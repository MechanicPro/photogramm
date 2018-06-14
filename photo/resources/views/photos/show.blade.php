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
                    @if (Auth::user()->id == $user->id)
                        <a href="/photo/create{{$post->id}}">
                            <button type="button"
                                    class="btn btn-outline-primary">Добавить новую фотографию
                            </button>
                        </a>
                    @endif
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
                                    <span class="badge badge-pill badge-secondary">Дата публикации: <b>{{$photo->updated_at}}</b></span>

                                    <like-component :id="{{$photo -> id}}"
                                                    :user_id="{{Auth::user()->id}}"
                                                    :post_id="{{$post->id}}">
                                    </like-component>
                                </div>
                                @if (Auth::user()->id == $user->id)
                                    <div class="col-md-8">
                                        <form action="/photo/destroy/{{$photo -> id}}/{{$post->id}}" method="post"
                                              accept-charset="UTF-8">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-outline-danger" type="submit">
                                                Удалить фотографию
                                            </button>
                                        </form>
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