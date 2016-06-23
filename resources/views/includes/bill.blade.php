<div class="container">
    <h2>Koszyk</h2>
      <div class="col-md-6">
          <table class="table">
              <thead>
              <tr>
                  <th>Tytuł </th>
                  <th>Ilość</th>
                  <th>Cena</th>
              </tr>
              </thead>

              <tbody>

              @if($books != null)

                  @foreach($books as $book)

                      <tr>
                          <td>{{ $book->title }}</td>
                          <td><a href="{{ route('RemoveOneItem',$book->id) }}" class="btn btn-default" role="button">-</a>
                              {{ $book->quantity }} <a href="{{ route('AddOneItem',$book->id) }}" class="btn btn-default" role="button">+</a>
                          </td>
                          <td>{{ $book->price * $book->quantity  }}</td>
                          <td><a href="{{ route('RemoveItem',$book->id) }}" class="btn btn-danger" role="button"><i class="glyphicon glyphicon-trash"></i></a>
                          </td>
                      </tr>

                  @endforeach

              @endif


              </tbody>
          </table>

          <hr>
            <h3>Suma: {{ $totalPrice }} zł</h3>

          <hr>
          <a href="{{ route('AddressDetails') }}" class="btn btn-default btn-lg" role="button">Przejdź do kasy</a>
      </div>
</div>
<br>
