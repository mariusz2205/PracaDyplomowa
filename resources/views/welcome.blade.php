@extends('layouts.app')

@section('content')

    <div class="container">
        @include('includes.slider')

        <h2 class="text-center" id="WeRecomend">Polecamy</h2><hr>
        @include('includes.recomended-books')

        <h2 class="text-center" id="about">O nas</h2><hr>
        @include('includes.about')

        <h2 class="text-center" id="Contact">Kontakt</h2><hr>
        @include('includes.contact-form')
    </div>

@endsection
