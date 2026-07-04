<nav class="mb-8 flex flex-wrap gap-2 border-b border-gray-200 pb-4" aria-label="Account">
    <a href="{{ route('account.orders') }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('account.orders*') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Orders</a>
    <a href="{{ route('account.profile') }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('account.profile*') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Profile</a>
</nav>
