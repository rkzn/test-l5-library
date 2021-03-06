<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Books') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
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
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Books') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>{{ link_to_route('books.authors', 'Authors') }}</li>
                        <li>{{ link_to_route('books.index', 'Books') }}</li>


                    </ul>

                    <!-- Right Side Of Navbar -->


                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                    @if (Auth::check())
                    {{ link_to_route('books.create', 'Add book', [], ['class' => 'btn btn-info btn-sm navbar-btn navbar-right']) }}
                    @endif
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(function() {
            var wrap_book_authors = {
                el: $(".wrap_book_authors"),
                init: function() {
                    this.bind_form();
                    this.bind_pagination();
                    this.bind_authors();
                    this.el.find('.loading').hide();
                    console.log('wrap_book_authors.init');
                },
                loading: function () {
                    this.el.find('.loading').show();
                    this.el.find('form').hide();
                },
                bind_form: function() {
                    wrap_book_authors.el.find('form').submit(function(e){
                        $action = $(e.target).attr('action');
                        $data = $(e.target).serialize();
                        wrap_book_authors.loading();
                        $.ajax({
                            type: "POST",
                            url:  $action,
                            data: $data,
                            success: function(data){
                                wrap_book_authors.el.html(data);
                                wrap_book_authors.init();
                            },
                            error: function(){
                                alert("failure");
                            }
                        });
                        return false;

                    });
                },
                bind_pagination: function () {
                    wrap_book_authors.el.find(".pagination a").each(function () {
                        $(this).click(function () {
                            wrap_book_authors.loading();
                            $el = $(this);
                            $.ajax({
                                type: "GET",
                                url: $el.attr('href'),
                                success: function(data){
                                    wrap_book_authors.el.html(data);
                                    wrap_book_authors.init();
                                },
                                error: function(){
                                    alert("failure");
                                }
                            });
                            return false;
                        });
                    });
                },
                bind_authors: function(){
                    wrap_book_authors.el.find(".nav_authors a").click(function (){
                        $checkbox = $(this).find('input');
                        $flag = $checkbox.is(':checked');
                        console.log('checkbox', $flag);
                        $checkbox.prop('checked', !$flag).trigger("change");
                        return false;
                    });
                }
            };
            wrap_book_authors.init();
        });
    </script>
</body>
</html>
