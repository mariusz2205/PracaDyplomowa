@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="col-md-6 col-md-offset-3">
          @foreach($bookDetails as $key => $value)
            <b>{{ $key }}: </b> {{ $value }}<br>
          @endforeach
          <hr>
          <h3>Wybrane kategorie</h3>
          @if(isset($categories) && !empty($categories))
            @foreach($categories as $key => $value)
             <h4></b> {{ $value }}  <a href="{{ route('RemoveItemFromCategoriesSessionVariable',array($value,$value)) }}">usuń</a></h4>
            @endforeach
          @endif

        </div>
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Dodaj Kategorie</h3></header>
            <form action="{{ route('PostNewCategorie') }}"  method="post">

                <div class="form-group">
                    <label for="title">kategoria</label>
                    <input type="text" name="categorie" class="form-control" value="" id="title">
                </div>


                <button type="submit" class="btn btn-primary">Dodaj kategorie</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>

            <a href="{{ route('AddNewProduct') }}">Poprzedni krok</a> &nbsp
            <a href="{{ route('AddAuthors') }}">Następ krok</a>
        </div>

    </div>


    @include('includes.errors')
@endsection
