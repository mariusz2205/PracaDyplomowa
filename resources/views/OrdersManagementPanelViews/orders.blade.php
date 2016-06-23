@extends('layouts.app')

@section('content')

    <div class="container">

      <form action="{{ route('setOrderNumberSessionVariable') }}" method="POST">
          {!! csrf_field() !!}

          <div class="form-group">
              <label for="search" > Wyszukaj</label>
              <input type="text" class="form-control" name = "orderNumber">
          </div>


          <input type="submit" value="Wyszukaj" class="btn btn-default">
      </form>
      <br>
@if(isset($order) && !empty($order))
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">
            <b> Numer zamówienia:</b> {{ $order->id }} &nbsp&nbsp  <b>Status zamówienia:</b> {{ $order->status }}
        </div>
        <div class="panel-body">
            <h3>Użytkownik</h3>
            <b>Imie:</b> {{ $order->user->name }}<br>
            <b>Nazwisko:</b> {{ $order->user->surname }}
            <hr>
            <h3>Dane kontaktowe</h3>
            <b>Email:</b> {{ $order->user->email }}<br>
            <b>Numer telefonu:</b> {{ $order->phone_number  }}
            <hr>
            <h3>Szczegóły zamówienia</h3>
            @foreach($order->books as $key => $book)
              <h5>{{ $key + 1  }})</h5>
            <b>Id:</b>{{ $book->pivot->book_id }} <br> <b>Tytuł księżki:</b> {{ $book->title }}<br> <b>ilość: </b> {{ $book->pivot->quantity}}<br><hr>
            @endforeach
            <h2><b>Cena: </b>{{ $order->price }} zł</h2>

            @if($order->status == "Oczekiwanie na wpłate")
                <a href="{{ url('/'.$order->id.'/Opłacono') }}">Zmień status zamówienia na : <b>Opłacono</b></a>
                <br>
                <a href="{{ url('/'.$order->id.'/Zrealizowano') }}">Zmień status zamówienia na : <b>Zrealizowano</b></a>
            @elseif($order->status == "Opłacono")
                <a href="{{ url('/'.$order->id.'/Oczekiwanie na wpłate') }}">Zmień status zamówienia na : <b>Oczekiwanie na wpłate</b></a>
                <br>
                <a href="{{ url('/'.$order->id.'/Zrealizowano') }}">Zmień status zamówienia na : <b>Zrealizowano</b></a>

            @elseif($order->status == "Zrealizowano")
                <a href="{{ url('/'.$order->id.'/Oczekiwanie na wpłate') }}">Zmień status zamówienia na : <b>Oczekiwanie na wpłate</b></a>
                <br>
                <a href="{{ url('/'.$order->id.'/Opłacono') }}">Zmień status zamówienia na : <b>Opłacono</b></a>

            @endif
        </div>
@else
  <h3>Wyszukaj zamówienie wpisując jego numer</h3>
@endif

      </div>



@endsection
