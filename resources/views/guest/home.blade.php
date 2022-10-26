<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Laravel</title>
            <!-- Style -->
            <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- FontAwesome -->
        <script src="https://kit.fontawesome.com/77b4cc17b1.js" crossorigin="anonymous"></script>

        <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.53.0/maps/maps.css'>
        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.53.0/maps/maps-web.min.js"></script>
        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.53.0/services/services-web.min.js"></script>
       
    <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

         <script defer src="{{ asset('js/front.js') }}" ></script>
         
    </head>
    <body>
      
            <div id="root"></div>
        
    </body>
</html>
