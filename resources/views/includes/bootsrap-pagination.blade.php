<div class="container text-center">
    <nav>
        <ul class="pagination">
            @if( $currentPage != 1)
                <li>
                    <a href="{{ route('assortment',$currentPage - 1) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @for($i = 0 ; $i < $totalNumOfPages ; $i++)

                @if($i + 1 == $currentPage)
                    <li class="active" ><a href="{{ route('assortment',$i+1) }}" >{{ $i + 1 }}</a></li>
                @else
                    <li><a href="{{ route('assortment',$i+1) }}">{{ $i + 1 }}</a></li>
                @endif

            @endfor

            @if($totalNumOfPages != $currentPage)
                    <li>
                        <a href="{{ route('assortment',$currentPage + 1) }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
            @endif

        </ul>
    </nav>
</div>