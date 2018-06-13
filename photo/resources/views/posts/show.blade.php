@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Лента пользователя {{$user->name}} <span
                                class="badge badge-pill badge-info">{{count($posts)}}</span></div>
                    @if (Auth::user()->id == $user->id)
                        <a href="/post/create">
                            <button type="button"
                                    class="btn btn-outline-primary">Добавить новую ленту
                            </button>
                        </a>
                    @endif
                    @foreach ($posts as $key => $post)
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary"><a
                                            href="/photo/show{{$post -> id}}">{{$post->name_post}}</a></li>
                                <li class="list-group-item list-group-item-secondary">{{$post->description}}</li>
                            </ul>
                            <span class="badge badge-pill badge-secondary">Дата публикации: <b>{{$post->updated_at}}</b></span>
                            @if (Auth::user()->id == $user->id)
                                <div class="col-md-8">
                                    <form action="/post/destroy{{$post -> id}}" method="post"
                                          accept-charset="UTF-8">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-outline-danger" type="submit">
                                            Удалить ленту
                                        </button>
                                        <a href="/post/update/{{$post -> id}}/{{$post->name_post}}/{{$post->description}}">
                                            <button type="button" class="btn btn-outline-warning">Редактировать ленту
                                            </button>
                                        </a>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                </div>
                <?php echo $posts->render(); ?>
            </div>
        </div>
    </div>
@endsection
@endauth
