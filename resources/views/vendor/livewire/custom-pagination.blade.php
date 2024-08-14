<div class="d-flex align-items-center mx-auto mx-md-0 ml-md-auto">
    @if ($paginator->hasPages())
    {{-- Previous Page Link --}}
    @if (!$paginator->onFirstPage())
    <p class="pagi_num" wire:click="previousPage" rel="prev"> {{ '<<' }} </p>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)

            @foreach ($element as $page => $url)
            <p class="{{ $paginator->currentPage() == $page ? 'pagi_num_active' : 'pagi_num' }}"
                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">{{ $page }}</p>
            @endforeach
            @endforeach

            {{-- Next Page Link --}}
            @if (!$paginator->onLastPage())
            <p class="pagi_num" wire:click="nextPage" rel="next"> {{ '>>' }} </p>
            @endif
            @endif
</div>