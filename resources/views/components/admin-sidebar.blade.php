<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-white">{{ config('app.name') }}</a>
        <p class="mt-1 text-xs text-blue-200">Site manager</p>
    </div>

    <nav class="admin-sidebar-nav">
        <p class="admin-sidebar-label">Overview</p>
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Dashboard</a>

        <p class="admin-sidebar-label">Store</p>
        <a href="{{ route('admin.products.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">Products</a>
        <a href="{{ route('admin.categories.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">Categories</a>
        <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">Orders</a>

        <p class="admin-sidebar-label">Newsletter</p>
        <a href="{{ route('admin.newsletters.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.newsletters.*') ? 'is-active' : '' }}">Newsletters</a>
        <a href="{{ route('admin.subscribers.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.subscribers.*') ? 'is-active' : '' }}">Subscribers</a>

        <p class="admin-sidebar-label">Site content</p>
        <a href="{{ route('admin.settings.contact') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.contact') ? 'is-active' : '' }}">Contact info</a>
        <a href="{{ route('admin.settings.homepage') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.homepage') ? 'is-active' : '' }}">Homepage</a>
        <a href="{{ route('admin.settings.footer') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.footer') ? 'is-active' : '' }}">Footer & trust bar</a>
        <a href="{{ route('admin.settings.pages') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.pages*') ? 'is-active' : '' }}">Site pages</a>
        <a href="{{ route('admin.settings.newsletter') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.newsletter') ? 'is-active' : '' }}">Newsletter section</a>

        <p class="admin-sidebar-label">System</p>
        <a href="{{ route('admin.settings.account') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.account*') ? 'is-active' : '' }}">Admin login</a>
        <a href="{{ route('admin.users.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Users</a>
        <a href="{{ route('admin.settings.payments') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.payments') ? 'is-active' : '' }}">Payments</a>
        <a href="{{ route('admin.settings.rental') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.rental') ? 'is-active' : '' }}">Rental & penalties</a>
    </nav>

    <div class="admin-sidebar-footer">
        <a href="{{ route('home') }}" class="admin-sidebar-link" target="_blank" rel="noopener">View public site</a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="admin-sidebar-link w-full text-left">Sign out</button>
        </form>
    </div>
</aside>
