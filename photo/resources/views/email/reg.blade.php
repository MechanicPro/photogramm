<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="links">
                    <p>Пользователь с именем: <b>{{$name}}</b> и почтой <b>{{$email}}</b> успешно зарегестрирован!</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>