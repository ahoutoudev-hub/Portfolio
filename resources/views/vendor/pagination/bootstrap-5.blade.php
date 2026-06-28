@if ($paginator->hasPages())
<nav class="admin-pagination" aria-label="Pagination">
  <div class="admin-pagination-info">
    Affichage de <strong>{{ $paginator->firstItem() }}</strong>
    à <strong>{{ $paginator->lastItem() }}</strong>
    sur <strong>{{ $paginator->total() }}</strong> résultats
  </div>

  <ul class="admin-pagination-list">

    {{-- Précédent --}}
    @if ($paginator->onFirstPage())
      <li class="ap-item ap-item--disabled">
        <span class="ap-link">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
          </svg>
        </span>
      </li>
    @else
      <li class="ap-item">
        <a class="ap-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Page précédente">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
          </svg>
        </a>
      </li>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="ap-item ap-item--dots"><span class="ap-link">…</span></li>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="ap-item ap-item--active" aria-current="page">
              <span class="ap-link">{{ $page }}</span>
            </li>
          @else
            <li class="ap-item">
              <a class="ap-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Suivant --}}
    @if ($paginator->hasMorePages())
      <li class="ap-item">
        <a class="ap-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Page suivante">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </li>
    @else
      <li class="ap-item ap-item--disabled">
        <span class="ap-link">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </span>
      </li>
    @endif

  </ul>
</nav>
@endif
