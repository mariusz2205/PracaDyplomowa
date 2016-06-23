<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Volkhov' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Courgette&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Lato';


        }
        .nav
        {
          font-family: 'Roboto Slab', serif;
        }
        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top nav">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand nav__brand" href="{{ url('/') }}">
                    Nazwa Sklepu
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('assortment',1) }}">Wszystkie kategorie</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/#about') }}">O sklepie</a></li>
                </ul>

                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/#contact') }}">Kontakt</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                     @if(Session::has('ShopingCard'))
                        <li><a href="{{ route('shopingCard') }}"><i class="fa fa-btn glyphicon glyphicon-shopping-cart"></i><span class="ShopingCardNumOfItems">{{count(Session::get('ShopingCard'))}}</span></a></li>

                    @else
                        <li><a href="{{ route('shopingCard') }}"><i class="fa fa-btn glyphicon glyphicon-shopping-cart"></i><span class="ShopingCardNumOfItems">0</span></a></li>

                    @endif

                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Zaloguj się</a></li>
                        <li><a href="{{ url('/register') }}">Zarejestruj się</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                              <i class="fa fa-btn glyphicon glyphicon-user"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->hasRole("Admin"))
                                    <li><a href="{{ route('AddNewUser') }}">Utwóż nowe konto</a></li>
                                    <li><a href="{{route('ShowUsers',1)}}">Edytuj istniejące konta</a></li>
                                    <li><a href="{{route('ShowOrders')}}">Zamówienia</a></li>
                                    <li><a href="{{ route('AddNewProduct') }}">Dodaj produkt</a></li>

                                @endif


                                <li><a href="{{ url('/home') }}"><i class="fa fa-btn glyphicon glyphicon-home"></i>System rekomendacji</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Wyloguj się  </a></li>
                            </ul>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')




    <footer>
        <div class="footer">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <p class="copyright text-center">Copyright &copy; Mariusz Dziedziniewicz 2016
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script>
        var token = '{{Session::token()}}';
        var url = '{{ route('addToShopingCard') }}';
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
