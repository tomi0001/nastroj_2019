<html>
    <head>
        <title>Dzienniczek nastrojów - @yield('title')</title>
      <link href="{{ asset('./css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        
        <script src="{{ asset('./js/app.js')}}"></script>

       
    </head>
    <body>


        <div id='body_register'>
            <div id="menu">
                <div class="empty_menu">
                    &nbsp;
                </div>
                <div class="menu">
                    <a class="menu" href="{{url('/Main')}}">GŁÓWNA STRONA</a>
                </div>
                <div class="menu">
                    <a class="menu" href="{{url('/Produkt/Search')}}">WYSZUKAJ</a>
                </div>
                
                <div class="menu">
                    
                    <a class="menu" href="{{url('/Produkt/Edit')}}">USTAWIENIA KONTA</a>
                    
                </div>
                <div class="menu">
                    <a class="menu" href="{{url('/User/Logout')}}">WYLOGUJ</a>
                </div>
            </div>
            <div id="top_main">
              
              @yield('content')
              
            </div>
        <br>

            
        </div>
    </body>
</html>