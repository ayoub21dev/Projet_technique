<div class="px-6 py-4 flex items-center justify-between border-t border-slate-100 bg-slate-50/50">
  <p class="text-sm text-slate-500">
    Showing <span class="font-medium">{{ $contacts->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $contacts->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $contacts->total() }}</span> results
  </p>
  
  <div id="pagination-container" class="eco-pagination">
    @if($contacts->hasPages())
      {{-- Previous Page --}}
      @if($contacts->onFirstPage())
        <span class="eco-pagination-btn opacity-50 cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
      @else
        <a href="{{ $contacts->previousPageUrl() }}" class="eco-pagination-btn">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
      @endif

      {{-- Page Numbers --}}
      @foreach($contacts->getUrlRange(max(1, $contacts->currentPage() - 2), min($contacts->lastPage(), $contacts->currentPage() + 2)) as $page => $url)
        @if($page == $contacts->currentPage())
          <span class="eco-pagination-btn active">{{ $page }}</span>
        @else
          <a href="{{ $url }}" class="eco-pagination-btn">{{ $page }}</a>
        @endif
      @endforeach

      {{-- Next Page --}}
      @if($contacts->hasMorePages())
        <a href="{{ $contacts->nextPageUrl() }}" class="eco-pagination-btn">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      @else
        <span class="eco-pagination-btn opacity-50 cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
      @endif
    @endif
  </div>
</div>
