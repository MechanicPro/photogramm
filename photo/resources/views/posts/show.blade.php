@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Лента пользователя {{$user->name}} <span
                                class="badge badge-pill badge-info">{{count($posts)}}</span></div>

                    @foreach ($posts as $key => $post)
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary"><a
                                            href="/photo/show{{$post -> id}}">{{$post->name_post}}</a></li>
                                <li class="list-group-item list-group-item-secondary">{{$post->description}}</li>
                            </ul>
                            @if (Auth::user()->id == $user->id)
                                <a class="badge badge-danger" href="/post/destroy{{$post -> id}}">Удалить ленту</a>
                                <a class="badge badge-warning"
                                   href="/post/update/{{$post -> id}}/{{$post->name_post}}/{{$post->description}}">Редактировать
                                    ленту</a>
                            @endif
                            <span class="badge badge-pill badge-secondary">Дата публикации: <b>{{$post->date}}</b></span>
                        </div>
                        <hr>
                    @endforeach

                </div>
                @if (Auth::user()->id == $user->id)
                    <a class="badge badge-success" href="/post/create">Добавить новую ленту...</a>
                @endif
                <?php echo $posts->render(); ?>
            </div>
        </div>
    </div>
@endsection
@endauth
