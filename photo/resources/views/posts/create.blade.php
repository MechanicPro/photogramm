@extends('layouts.app')
@auth
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="title m-b-md">
                <h1>Добавление новой ленты</h1>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Новая лента</div>
                    <div class="card-body">
                        <form method="POST" action="/post/store">
                            @csrf

                            <div class="form-group row">
                                <label for="name_post"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Наименование ленты') }}</label>

                                <div class="col-md-6">
                                    <input id="name_post" type="name_post"
                                           class="form-control" name="name_post"
                                           value="{{ old('name_post') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Описание ленты') }}</label>

                                <div class="col-md-6">
                                <textarea id="description" type="description"
                                          class="form-control" name="description"
                                          required autofocus></textarea>
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