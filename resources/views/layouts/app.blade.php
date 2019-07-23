<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashbord</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dashbord.css">
    <link rel="stylesheet" href="/css/styleAnalysis.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>

<body >
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="collapse navbar-collapse" id="navbarsExampleDefault" data-set="bs">
                    <ul class="navbar-nav mr-auto js-append-around">
                        <li class="nav-item active">
                            <a class="nav-link" href="/index">{{trans('language.Home')}} <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 js-append-around">
                        <input class="form-control mr-sm-2" type="text" placeholder=" {{trans('language.Search')}}" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{trans('language.Search')}}</button>
                    </form>
                </div>
        </nav>
        <div class="">
            <div class="c-offcanvas-content-wrap">
                <div class="container-fluid">
                    <div class="row">
                        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar mt-1"style="margin-top:-45px;" data-set="bs-sidebar">
                            <div class="js-append-around">
                                <ul class="nav nav-pills flex-column" >
                                    <li class="nav-item">
                                        <a class="nav-link text-light bg-dark" href="/dashbord">
                                            {{trans('language.Overview')}}
                                        </a>
                                    </li>
                                    <li class="nav-item mt-1">
                                        <a class="nav-link text-light bg-dark" href="/add">
                                            {{trans('language.Add Question')}}
                                        </a>
                                    </li>
                                    <li class="nav-item mt-1">
                                        <a class="nav-link text-light bg-dark" href="/analysis">
                                            {{trans('language.analysis')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                            
                            {{-- posh here the content of dashbord.blade.php  also update.blade.php with the function yield --}}
                         @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="/js/scriptAnalysis.js"></script>
        <script src="/js/bootstrap.min.js"></script>
    </body>

</html>