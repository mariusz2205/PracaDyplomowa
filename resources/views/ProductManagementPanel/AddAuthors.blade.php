@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="col-md-6 col-md-offset-3">

          <h3>Szczegóły książki</h3>
          @foreach($bookDetails as $key => $value)
            <b>{{ $key }}: </b> {{ $value }}<br>
          @endforeach
          <hr>
          <h3>Wybrane kategorie</h3>
          @if(isset($categories) && !empty($categories))
            @foreach($categories as $key => $value)
            </b> {{ $value }}  <a href="{{ route('RemoveItemFromCategoriesSessionVariable',array($value,$value)) }}">usuń</a><br>
            @endforeach
          @endif
          <h3>Autorzy</h3>
          @if(isset($authors) && !empty($authors))
            @foreach($authors as $key => $value)
             <h4></b> {{ $value['name'] }}  {{ $value['surname'] }}  <a href="{{ route('RemoveItemFromAuthorsSessionVariable',array($value['name'],$value['surname'])) }}">usuń</a></h4>
            @endforeach
          @endif
        </div>
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Dodaj Autora</h3></header>
            <form action="{{ route('PostNewAuthor') }}"  method="post">

                <div class="form-group">
                    <label for="name">Imie</label>
                    <input type="text" name="name" class="form-control" value="" id="name">
                </div>

                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" name="surname" class="form-control" value="" id="surname">
                </div>


                <button type="submit" class="btn btn-primary">Dodaj autora</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>

            <a href="{{ route('AddCategories') }}">Poprzedni krok</a>
            <a href="{{ route('AddImg') }}">Następny krok</a>
        </div>

    </div>


    @include('includes.errors')
@endsection
