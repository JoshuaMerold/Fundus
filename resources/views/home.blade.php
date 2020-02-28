<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fundus') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>


<body class="home-body">

@include('sidebar')
@include('topbar')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
              <div>
                <button class="button-add-lessons" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="credits"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <li><a href="/add/module">Modul hinzufügen</a></li>
		              <li><a href="/add/lesson">Lehrveranstaltung hinzufügen</a></li>
                </div>
              </div>

                @include('inc.messages')
                <!-- <a href="/add/module">Modul hinzufügen</a>
                <a href="/add/lesson">Lehrveranstaltung hinzufügen</a> -->

                @foreach($modules as $module)

                <div class="mt-3 module-card col-md-5">
                    <b>{{$module->name}}</b><br>
                    <hr>
                    @foreach($lessons as $lesson)
                      @if($lesson->moduleid == $module->id)
                        <a href="/{{$lesson->id}}/show/zusammenfassung">{{$lesson->lessonname}}</a>, {{$lesson->professorname}}<br>
                      @endif
                    @endforeach

                </div>
                @endforeach
                <!-- ->with('users',$user)->with('courses', $courses)->with('modules', $modules)->with('lessons', $lessons); -->
            </div>
        </div>
    </div>
</div>
</body>
