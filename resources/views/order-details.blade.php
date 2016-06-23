@extends('layouts.app')

@section('content')

    <div class="well text-center">
        <div class="panel-success">

            Zamówienie zostało złożne
            Wykonaj przelew {{ $price }} zł na konto :1343110312123 <br>
            w tytule podaj nr zamówienia {{ $orderId }}

        </div>
        <hr>
        <h4>Zamówione książki</h4>
        @foreach($items as $item)
            <b>Tytuł:</b> {{ $item->title }} <b>ilość:</b>{{ $item->quantity }} <b>cena:</b> {{ $item->price }}<br>
        @endforeach

    </div>

@endsection
