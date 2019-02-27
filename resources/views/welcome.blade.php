<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet" type="text/css">
	       <meta name="csrf-token" content="{{ csrf_token() }}">
         <meta name="api-base-url" content="{{ url('/api/v1/') }}" />

        <!-- Styles -->
        <style>
            html, body {
                
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

        </style>
    </head>
    <body v-bind:class="style">

    <div id="app" v-bind:class="style">
       <app @style-change="onStyleChange"></app>
    </div>

 <script type="text/javascript" src="{{ mix('/js/vueapp.js') }}"></script>
    </body>
</html>
