<?php 
if (isset($select)){
    $select=session('selectQuestion');
}else{
    $select=1;
}
$selectQuestion = DB::table('langs')->where('id', "$select")->first();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <base href="/"> --}}
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/sweetalert.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
    <script src="/js/sweetalert.min.js"></script>
    <title>Mouse BANK el Maghrib</title>
    <style>
        *{
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body  > 
   
   
        <script>
                function myFunction() {
                  swal({
                    title: "Merci pour votre avis",
                    // text: "Here's a custom image.",
                    imageUrl: '/img/thumbs-up.jpg'
                  });
            
                  setTimeout(function () {
                    swal.close();
                  }, 3000);
                }
        </script>
    
       
      

        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <img src="/img/logo.png" class="float-left" style="width:30%;height:70%;" alt="">
                </div>
                <div class="col ">
                    <a href="/index/fr">
                        <div class="btn btn-outline-primary float-right @if($language === 'fr')
                            {{"active"}}
                            @endif">
                            fr
                        </div>
                    </a>
                    <a href="/index/ar">
                        <div class="btn btn-outline-primary float-right mx-4 @if($language === 'ar')
                            {{"active"}}
                            @endif">
                            ar
                        </div>
                    </a>
                    <a href="/index/en">
                        <div class="btn btn-outline-primary float-right @if($language === 'en')
                            {{"active"}}
                            @endif">
                            en
                        </div>
                    </a>
                </div>
            </div>
            <div>
                <h1 class=" text-center mt-3">
                    {{$selectQuestion->$language}}
                    
                </h1>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <a href="/insertViewSatisfied" class="text-decoration-none text-dark" onclick="myFunction()">
                        <span style='font-size:150px; margin-left:65px;' class=""> &#128578;</span>
                        <h2 class="text-center mt-2">{{trans('language.Satisfied')}}</h2>
                    </a>
                </div>
                <div class="col ">
                    <a href="/insertALittleSatisfied" class="text-decoration-none text-dark" onclick="myFunction()">
                        <span style='font-size:150px; margin-left:65px;'> &#128533;</span>
                        <h2 class=" text-center mt-2">{{trans('language.A Little Satisfied')}}</h2>
                    </a>
                </div>
                <div class="col ">
                    <a href="/insertUnsatisfied" class="text-decoration-none text-dark" onclick="myFunction()">
                        <span style='font-size:150px; margin-left:65px;' class="">&#128544;</span>
                        <h2 class="text-center mt-2">{{trans('language.Unsatisfied')}}</h2>
                    </a>
                </div>
            </div>
        </div>

 </body>

</html> 