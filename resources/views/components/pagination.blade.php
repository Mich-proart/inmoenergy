@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
            @else
                <li wire:click=" previousPage" class="page-item"><a class="page-link" href="#">Anterior</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item disabled"> <button class="page-link">{{$page}}</button></li>
                        @else
                            <li class="page-item" wire:click="gotoPage({{$page}})"> <button class="page-link">{{$page}}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li wire:click="nextPage" class="page-item"><a class="page-link" href="#">siquiente</a></li>

            @else
                <li class="page-item disabled"><a class="page-link" href="#">siquiente</a></li>
            @endif
        </ul>
    </nav>
@endif