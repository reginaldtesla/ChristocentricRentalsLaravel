@props(['toc' => []])

<div class="container-site doc-page">
    <div @class(['doc-layout', 'doc-layout--full' => empty($toc)])>
        @if (! empty($toc))
            <nav class="doc-toc" aria-label="Page sections">
                <p class="doc-toc-title">On this page</p>
                <ul class="doc-toc-list">
                    @foreach ($toc as $id => $label)
                        <li><a href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </nav>
        @endif
        <div class="doc-body">
            {{ $slot }}
        </div>
    </div>
</div>
