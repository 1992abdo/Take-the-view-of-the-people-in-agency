@extends('layouts.app')
@section('content')
<div class="row">
                <div class="col-sm-7">
                    <h1>{{trans('language.Dashboard')}}</h1>
                </div>

                <div class="col-sm-5 ">
                    <div class="row">
                        <a href="/dashbord/en" class="">
                            <div class="btn btn-outline-primary @if($language === 'en') {{"active"}} @endif">
                                en
                            </div>
                        </a>
                        <a href="/dashbord/fr" class="mx-4">
                            <div class="btn btn-outline-primary @if($language === 'fr') {{"active"}} @endif">
                                fr
                            </div>
                        </a>
                        <a href="/dashbord/ar" class="mr-4">
                            <div class="btn btn-outline-primary @if($language === 'ar') {{"active"}} @endif">
                                ar
                            </div>
                        </a>
                        <a href="/logout" class="mr-4	text-dark">
                            <div class="btn btn-outline-success">
                                {{trans('language.Log out')}}
                            </div>
                        </a>
                    </div>  
                </div>
            </div>
    <div class="row mx-5 " @if ($language==='ar') dir=rtl  @endif >
        <ol>   
            @foreach ($langs as $lang) 
                <li>
                    <p class='text-light bg-secondary rounded p-2 text-center'>
                    {{ $lang->$language}}
                    </p>
                </li>
                <div class="row mb-4 "  style="width:450px">
                    <div class="col-5">
                        <!-- partie checkbox -->
                        <form action="/select" method="POST">
                            {{csrf_field()}}
                            <input type="checkbox" name="selectQuestion" value="{{$lang->id}}">
                            <input type="submit" value="{{trans('language.Select')}}" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-5">
                                <!-- partie delete question -->
                                <div class="btn btn-outline-danger">
                                    <a href="/dashbord/{{$lang->id}}/delete">{{trans('language.delete')}}</a>
                                </div>
                            </div>
                            <div class="col-7">
                                <!-- partie update question -->
                                <div class="btn btn-outline-success">
                                    <a href="/dashbord/{{$lang->id}}/edit">{{trans('language.update')}}</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach
            {{session('selectQuestion')}}                                 
        </ol>      
    </div>
@endsection