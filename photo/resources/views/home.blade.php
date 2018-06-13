@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Моя лента <span
                                class="badge badge-pill badge-info">{{count($myPosts)}}</span></div>
                    @extends('layouts.error')
                    <a href="/post/create">
                        <button type="button"
                                class="btn btn-outline-primary">Добавить новую ленту
                        </button>
                    </a>
                    @if (count($myPosts) > 0)
                        @foreach ($myPosts as $key => $post)
                            @if (Auth::user()->id == $post->user_id)
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-primary"><a
                                                    href="/photo/show{{$post -> id}}">{{$post->name_post}}</a></li>
                                        <li class="list-group-item list-group-item-secondary">{{$post->description}}</li>
                                    </ul>
                                    <div class="col-md-8">
                                        <span class="badge badge-pill badge-secondary">Дата публикации: <b>{{$post->updated_at}}</b></span>
                                    </div>

                                    <div class="col-md-8">
                                        <form action="/post/destroy{{$post -> id}}" method="post"
                                              accept-charset="UTF-8">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-outline-danger" type="submit">
                                                Удалить ленту
                                            </button>
                                            <a href="/post/update/{{$post -> id}}/{{$post->name_post}}/{{$post->description}}">
                                                <button type="button" class="btn btn-outline-warning">Редактировать
                                                    ленту
                                                </button>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    @else
                        <span class="badge badge-pill badge-warning">Лента пока ещё пуста</span>
                    @endif

                </div>
                <?php echo $myPosts->render(); ?>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Другие ленты</div>

                    @foreach ($anyPosts as $key => $post)
                        @if (Auth::user()->id != $post->user_id)
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b><a
                                                    href="/photo/show{{$post -> id}}">{{$post->name_post}}</a></b></li>
                                    <li class="list-group-item">Описание: <b>{{$post->description}}</b></li>
                                    <li class="list-group-item"><b>{{$post->updated_at}}</b></li>
                                    <li class="list-group-item"><a
                                                href="/post/show/user{{$post -> user_id}}"><b>{{$post->user->name}}</b></a>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection
@endauth
