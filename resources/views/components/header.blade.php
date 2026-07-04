<header class="sticky top-0 z-50 border-b border-gray-200 bg-white">
    <div class="container-site">
        <div class="flex items-center gap-4 py-3 lg:py-4">
            <button type="button" class="p-1 text-gray-700 lg:hidden" data-mobile-menu-toggle aria-label="Open menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <a href="{{ route('home') }}" class="shrink-0">
                <img src="{{ asset('images/brand/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto md:h-14">
            </a>

            <form action="{{ route('shop') }}" method="GET" class="hidden min-w-0 flex-1 lg:block lg:max-w-xl lg:mx-6">
                <div class="relative">
                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search cameras, lenses, lights..."
                        class="w-full rounded border border-gray-300 bg-white py-2.5 pl-4 pr-11 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <button type="submit" class="absolute right-0 top-0 flex h-full items-center px-3 text-gray-500 hover:text-primary" aria-label="Search">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/></svg>
                    </button>
                </div>
            </form>

            <div class="ml-auto flex items-center gap-3">
                @auth
                    <a href="{{ route('account.orders') }}" class="hidden text-sm text-gray-700 hover:text-primary sm:inline">Account</a>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm text-gray-700 hover:text-primary sm:inline">Sign in</a>
                @endauth
                <a href="{{ route('compare.index') }}" class="relative hidden items-center gap-1.5 text-sm text-gray-800 hover:text-primary sm:flex {{ request()->routeIs('compare.*') ? 'text-primary' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Compare</span>
                    @if ($compareCount > 0)
                        <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-gray-900 px-1 text-[11px] font-medium text-white">{{ $compareCount }}</span>
                    @endif
                </a>
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 text-sm text-gray-800 hover:text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="hidden sm:inline">Cart</span>
                    @if ($cartCount > 0)
                        <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-primary px-1 text-[11px] font-medium text-white">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <nav class="hidden border-t border-gray-100 lg:block">
            <ul class="flex flex-wrap items-center gap-1 py-1">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">Home</a></li>
                <li><a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop*') ? 'nav-link-active' : '' }}">All products</a></li>
                @foreach (array_slice($siteCategories, 0, 6) as $category)
                    <li><a href="{{ route('shop', ['category' => $category['slug']]) }}" class="nav-link">{{ $category['name'] }}</a></li>
                @endforeach
                <li class="ml-auto"><a href="{{ route('help') }}" class="nav-link">Help</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
            </ul>
        </nav>
    </div>

    <div class="hidden border-t border-gray-200 bg-white lg:hidden" data-mobile-menu>
        <div class="container-site space-y-1 py-3">
            <form action="{{ route('shop') }}" method="GET" class="mb-2">
                <input type="search" name="q" placeholder="Search gear..." class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
            </form>
            <a href="{{ route('home') }}" class="block px-2 py-2 text-sm text-gray-800">Home</a>
            <a href="{{ route('shop') }}" class="block px-2 py-2 text-sm text-gray-800">All products</a>
            @foreach ($siteCategories as $category)
                <a href="{{ route('shop', ['category' => $category['slug']]) }}" class="block px-2 py-2 text-sm text-gray-700">{{ $category['name'] }}</a>
            @endforeach
            <a href="{{ route('compare.index') }}" class="block px-2 py-2 text-sm text-gray-800">
                Compare
                @if ($compareCount > 0)
                    ({{ $compareCount }})
                @endif
            </a>
            <a href="{{ route('contact') }}" class="block px-2 py-2 text-sm text-gray-700">Contact</a>
            <a href="{{ route('help') }}" class="block px-2 py-2 text-sm text-gray-700">Help</a>
        </div>
    </div>
</header>
