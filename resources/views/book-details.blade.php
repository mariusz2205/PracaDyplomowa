@extends('layouts.app')

@section('content')
    <div class="container">
    @include('includes.informations-about-book')

        <h2 class="text-center">Mogą Cię również zainteresować</h2><hr>
        <div class="row">

            @foreach($Recomendedbooks as $Recomendedbook)
                <div class="col-md-2 text-center  recomended-book">

                    <a style="height: 150px" href="{{ url('/book-details/'.$Recomendedbook->id) }}" class="thumbnail">
                        @if (Storage::disk('local')->has($Recomendedbook->img))

                            <img style="height: 100px" src="{{ route('getProductImage',['filename'=>$Recomendedbook->img]) }}"  height="300" alt="book">
                        @else
                            <img style="height: 100px" src="{{ $Recomendedbook->img }}" alt="book">
                        @endif
                            {{ $Recomendedbook->title }}
                    </a>
                </div>
            @endforeach



        </div>



    </div>
@endsection
