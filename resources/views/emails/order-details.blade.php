<h4>
    Dziękujemy za złożenie zamówienia
</h4>
<p> Prosze wysłać przelew w wysokości {{ $price }} na nr konta (przykładowy nr konta)</p>
<p>W tytule przelewu podaj nr zamówienia {{ $order_id }}</p>
@foreach($items as $item)
   <b>Tytuł:</b> {{ $item->title }} <b>ilość:</b>{{ $item->quantity }} <b>cena:</b> {{ $item->price }}<br>
@endforeach