@props(['slug', 'productId' => null, 'compact' => false])

@php
    $inCompare = in_array($slug, $compareSlugs ?? [], true);
    $atLimit = ($compareCount ?? 0) >= ($compareMax ?? 4) && ! $inCompare;
@endphp

<form action="{{ $inCompare ? route('compare.destroy', $slug) : route('compare.store') }}" method="POST" class="inline">
    @csrf
    @if ($inCompare)
        @method('DELETE')
    @else
        <input type="hidden" name="product_id" value="{{ $productId }}">
    @endif
    <button
        type="submit"
        @disabled($atLimit)
        @class([
            'compare-add-btn',
            'is-active' => $inCompare,
            'is-compact' => $compact,
        ])
        title="{{ $inCompare ? 'Remove from compare' : ($atLimit ? 'Compare list is full' : 'Add to compare') }}"
    >
        @if ($inCompare)
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $compact ? 'In compare' : 'In compare' }}
        @else
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            {{ $compact ? 'Compare' : 'Add to compare' }}
        @endif
    </button>
</form>
