@extends('layouts.app')

@section('content')

    <div class="container">
        @if($product_filters != "none")
            <div class="container">
                <form action="{{ route('setProductFiltersSessionVariable') }}" method="POST">
                    {!! csrf_field() !!}

                    <div class="form-group ">

                        <input type="text" class="form-control " name = "search_product" placeholder="Wyszukaj">
                    </div>
                    <div class="funkyradio">


                    @if(count($product_filters)>0)
                        @foreach($product_filters as $product_filter)
                            @if(Session::has('productFilters') && in_array($product_filter->category, Session::get('productFilters')))

                                {{--<input type="checkbox" checked name="productFilters[]" value="{{ $product_filter->category}}"> {{ $product_filter->category}}--}}
                                    <div class="funkyradio-primary col-md-2">
                                        <input value="{{ $product_filter->category }}" type="checkbox"  name="productFilters[]" id="{{ $product_filter->category}}" checked/>
                                        <label for="{{ $product_filter->category}}">{{ $product_filter->category}}</label>
                                    </div>
                            @elseif(!Session::has('productFilters'))
                                    <div class="funkyradio-primary col-md-2">
                                        <input value="{{ $product_filter->category }}" type="checkbox"  name="productFilters[]" id="{{ $product_filter->category}}" checked/>
                                        <label for="{{ $product_filter->category}}">{{ $product_filter->category}}</label>
                                    </div>

                                {{--<input type="checkbox" checked name="productFilters[]" value="{{ $product_filter->category }}"> {{ $product_filter->category }}--}}
                            @else
                                    <div class="funkyradio-primary col-md-2">
                                        <input value="{{ $product_filter->category }}" type="checkbox"  name="productFilters[]" id="{{ $product_filter->category}}"/>
                                        <label for="{{ $product_filter->category}}">{{ $product_filter->category}}</label>
                                    </div>
                                {{--<input type="checkbox" name="productFilters[]" value="{{ $product_filter->category }}"> {{ $product_filter->category}}--}}
                            @endif

                        @endforeach
                    @endif
                    <br style="clear: both;">
                    <div class="text-center"><input type="submit" class="btn btn-default btn-lg " value="Wyszukaj"></div>
                </form>
            </div>
        @else
            <h3>Rekomendowane produkty</h3>
            <hr>
        @endif
    </div>
 </div>


    <br>
    <div class="container">

        @foreach ($books->chunk(6) as $chunk)
            <div class="row">
                <div class="col-md-12">
                @foreach ($chunk as $book)

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
                                    @if(Auth::user() && Auth::user()->hasRole("Admin") || Auth::user() && Auth::user()->hasRole("Storekeeper"))
                                      <a href="{{ route('RemoveBook',$book->id) }}" ><i class="glyphicon glyphicon-trash"></i></a>
                                    @endif
                                </div>


                            </div>
                        </div>




                @endforeach
                </div>
            </div>
        @endforeach

    </div>

    @include('includes.bootsrap-pagination')


@endsection
