<div class="row">

    

@foreach($books as $key => $book)
  <div class="col-sm-4 col-md-2 col-xs-6">


  <div class="thumbnail book">

      @if (Storage::disk('local')->has($book->img))

          <img style="height: 130px;" src="{{ route('getProductImage',['filename'=>$book->img]) }}"  width="450" height="350" alt="book">
      @else
          <img style="height: 130px;" src="{{ $book->img }}" alt="book" width="450" height="350">
      @endif

      <div class="text-center">
          <span class=" book__title">{{ $book->title }}</span>
      </div>
      <div class="book__author text-center">
          @foreach($book->authors as $author)

              <a href=""> {{ $author->name }} {{ $author->surname }}   </a>&nbsp;<br>

          @endforeach
      </div>

      <div class=" text-center">
          <a class="addToCard" data-id="{{ $book->id }}" href="#"><i class="fa fa-btn glyphicon glyphicon-shopping-cart"></i></a></li>
          {{ $book->price }}zł
      </div>

      <div class="text-center">
          <a href="{{ route('book-details',$book->id) }}">Szczegóły</a>
          <br>
          @if(Auth::user() && Auth::user()->hasRole("Admin"))
            <a href="{{ route('RemoveBook',$book->id) }}" ><i class="glyphicon glyphicon-trash"></i></a>
          @endif
      </div>


  </div>
  </div>
@endforeach


</div>
