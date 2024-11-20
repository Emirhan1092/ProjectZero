@if($paginator->hasPages())
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center">
            <!-- Önceki Sayfa -->
            @if(!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <i class="fa fa-angle-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif

            <!-- Sayfa Numaraları -->
            @foreach($elements as $element)
                @if(is_string($element))
                    <li class="page-item"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Sonraki Sayfa -->
            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>

            @endif
        </ul>
    </nav>
@endif
