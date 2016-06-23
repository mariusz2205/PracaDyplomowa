@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="col-md-6 col-md-offset-3">
            <header><h3>Dodaj nowy produkt</h3></header>
            <form action="{{route('PostNewProduct')}}"  method="post" enctype="multipart/form-data">
                {{-- Dzięki enctype="multipart/form-data" laravel wie że ma być uplądowany plik
                    bez tego nie zadziała
                --}}
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" class="form-control" @if(isset($bookDetails)) value ="{{$bookDetails['title']}}" @endif id="title">
                </div>

                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea class="form-control" id="description"  name="description">@if(isset($bookDetails)) {{$bookDetails['description']}} @endif</textarea>

                </div>

                <div class="form-group">
                    <label for="series">Seria</label>
                    <input type="text" name="series" class="form-control" @if(isset($bookDetails)) value ="{{$bookDetails['series']}}" @endif id="series">
                </div>

                <div class="form-group">
                    <label for="pages">Liczba stron</label>
                    <input type="number" name="pages" class="form-control" @if(isset($bookDetails)) value ="{{$bookDetails['pages']}}" @endif id="pages">
                </div>

                <div class="form-group">
                    <label for="price">Cena</label>
                        <input type="number" name="price" class="form-control" @if(isset($bookDetails)) value ="{{$bookDetails['price']}}" @endif id="price">
                </div>

                <div class="form-group">
                    <label for="cover">Rodzaj okładki</label>
                    <input type="number" name="cover" class="form-control" @if(isset($bookDetails)) value ="{{$bookDetails['cover']}}" @endif id="cover">
                </div>


                <button type="submit" class="btn btn-primary">Dalej
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>

    </div>


    @include('includes.errors')
    </button><br>
@endsection
