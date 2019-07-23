@extends('layouts.app')
@section('content')
<div class="row ml-4 ">
    <div class="container">
        <h1 class="text-center mt-3 text-secondary">{{trans('language.Add Question')}}</h1>
        <form action="addQuestion" class="controle-form" method="post">
            {{csrf_field()}}
            <input type="text" name="français" value="{{old('français')}}" placeholder="{{trans('language.Write the question in French')}}" class="form-control" >
            <input type="text" name="anglais" value="{{old('anglais')}}" placeholder="{{trans('language.Write the question in English')}}"
                class="form-control my-4" >
            <input type="text" name="arab" value="{{old('arab')}}" placeholder="{{trans('language.Write the question in Arabic')}}" class="form-control mb-5" >
            <input type="submit" class="btn btn-primary btn-block mb-5" name="submit" value="{{trans('language.Valid')}}">
           
        </form>
        {{-- this script to show the errors --}}
        @if(count($errors))
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger w-75 text-center mx-auto alert-dismissible fade show" role="alert">
                    {{$error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
            @endforeach
        @endif
        {{-- this script to show a confirmation msg --}}
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