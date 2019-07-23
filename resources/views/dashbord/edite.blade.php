
@extends('layouts.app')
@section('content')
    <div class="row ml-4 ">
        <div class="container">
            <h1 class="text-center mt-3 text-secondary">{{trans('language.Update question')}}</h1>
            <form action="/dashbord/{{$id->id}}/update" class="controle-form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <input type="text" name="français" value="{{$id->fr}}" placeholder="{{trans('language.Write the question in French')}}" class="form-control" >
                <input type="text" name="anglais" value="{{$id->en}}" placeholder="{{trans('language.Write the question in English')}}"
                    class="form-control my-4" >
                <input type="text" name="arab" value="{{$id->ar}}" placeholder="{{trans('language.Write the question in Arabic')}}" class="form-control mb-5" >
                <input type="submit" class="btn btn-primary btn-block mb-4" name="submit" value="{{trans('language.Valid')}}">
            </form>
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger w-75 mx-auto text-center" role="alert">
                        {{$error}}<br>
                    </div>  
                @endforeach
            @endif
            
            @if(session()->has('message'))
                <div class="alert alert-success w-75 mx-auto alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif                      
        </div>
    </div>
@endsection
