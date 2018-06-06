@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="title m-b-md">
                <h1>Добавление новой фотографии</h1>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Новая фотография</div>
                    @extends('layouts.error')
                    <div class="card-body">
                        <form method="POST" action="/photo/store{{$post_id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name_post"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Наименование фотографии') }}</label>

                                <div class="col-md-6">
                                    <input id="name_post" type="name_post"
                                           class="form-control" name="name_post"
                                           value="{{ old('name_post') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="path"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Выберете файл фотографии') }}</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="path"/>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Добавить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endauth