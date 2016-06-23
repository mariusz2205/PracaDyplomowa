<div class="row">

    <div class="col-md-6 col-lg-5">

        @if (Storage::disk('local')->has($book->img))

            <img src="{{ route('getProductImage',['filename'=>$book->img]) }}" class="img-fluid" width="350" height="350" alt="book">
        @else
            <img src="{{ $book->img }}" class="img-fluid" alt="Responsive image" alt="book">
        @endif
    </div>

    <div class="col-md-7">

        <h3> {{ $book->title }}</h3>


        @if(count($book->authors)>1)
            <span>Autorzy: </span>
        @else
            <span>Autor: </span>

        @endif
        @foreach($book->authors as $author)
            <a href=""> {{ $author->name }} {{ $author->surname }}   </a>&nbsp;
        @endforeach
        <br>
        @if($book->series != null)
            <span>Z serii: {{ $book->series }}</span><br>
        @endif

        @if($book->series != null)
            <span>Ilość Stron:  {{ $book->pages }}</span><br>
        @endif

        @if($book->categories != null)
            Kategorie:
            @foreach($book->categories as $category)
                <a href=""> {{ $category->category }}   </a>&nbsp;
            @endforeach
        @endif
        <br>
        @if($book->cover == 1)
            <span>Okładka : Twarda</span><br>
        @else
            <span>Okładka : Miękka</span><br>
        @endif

        <h4>Cena: {{ $book->price }} zł </h4>

        <div data-id="{{ $book->id }}">

            <button type="button"  class="addToCard btn btn-default btn-lg">
                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Dodaj do koszyka
            </button>

            @if(Auth::check() && Auth::user()->hasRole("Admin") || Auth::user() && Auth::user()->hasRole("Storekeeper"))
              <br>
              <br>
              <a href="{{ route('RemoveBook',$book->id) }}" ><i class="glyphicon glyphicon-trash"></i>Usuń produkt</a>
              <br>

            @endif


        </div>
    </div>

</div>
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title text-center">
                <a data-toggle="collapse" href="#collapse1">Opis</a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">{{$book->description}}</div>

        </div>
    </div>
</div>
