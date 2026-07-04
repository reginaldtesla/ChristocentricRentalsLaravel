@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-callout">
        <p><strong>Site manager</strong> — this area is separate from the customer storefront. Add and edit products, homepage banners, contact info, orders, and newsletters. When you save here, visitors see the updates on the public site.</p>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="admin-stat-card">
            <p class="admin-stat-label">Products</p>
            <p class="admin-stat-value">{{ $productCount }}</p>
            <a href="{{ route('admin.products.index') }}" class="admin-stat-link">Manage products</a>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Orders</p>
            <p class="admin-stat-value">{{ $orderCount }}</p>
            <p class="mt-1 text-xs text-amber-600">{{ $pendingOrders }} pending</p>
            <a href="{{ route('admin.orders.index') }}" class="admin-stat-link">View orders</a>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Subscribers</p>
            <p class="admin-stat-value">{{ $subscriberCount }}</p>
            <a href="{{ route('admin.subscribers.index') }}" class="admin-stat-link">Manage list</a>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Categories</p>
            <p class="admin-stat-value">{{ $categoryCount }}</p>
            <a href="{{ route('admin.categories.index') }}" class="admin-stat-link">Manage categories</a>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <section class="admin-panel">
            <h2 class="admin-panel-title">Store</h2>
            <ul class="admin-link-list">
                <li><a href="{{ route('admin.products.create') }}">Add new product</a></li>
                <li><a href="{{ route('admin.products.index') }}">Edit products &amp; stock</a></li>
                <li><a href="{{ route('admin.categories.index') }}">Product categories</a></li>
                <li><a href="{{ route('admin.orders.index') }}">Rental orders</a></li>
            </ul>
        </section>

        <section class="admin-panel">
            <h2 class="admin-panel-title">Newsletter</h2>
            <ul class="admin-link-list">
                <li><a href="{{ route('admin.newsletters.create') }}">Compose newsletter</a></li>
                <li><a href="{{ route('admin.newsletters.index') }}">Sent &amp; draft issues</a></li>
                <li><a href="{{ route('admin.subscribers.index') }}">Subscriber list</a></li>
                <li><a href="{{ route('admin.subscribers.export') }}">Export subscribers (CSV)</a></li>
            </ul>
        </section>

        <section class="admin-panel">
            <h2 class="admin-panel-title">Site content</h2>
            <ul class="admin-link-list">
                <li><a href="{{ route('admin.settings.contact') }}">Contact details</a></li>
                <li><a href="{{ route('admin.settings.homepage') }}">Homepage hero &amp; promos</a></li>
                <li><a href="{{ route('admin.settings.pages') }}">About, FAQ, Terms &amp; more</a></li>
                <li><a href="{{ route('admin.settings.footer') }}">Footer &amp; trust bar</a></li>
                <li><a href="{{ route('admin.settings.newsletter') }}">Newsletter signup copy</a></li>
            </ul>
        </section>

        <section class="admin-panel">
            <h2 class="admin-panel-title">System</h2>
            <ul class="admin-link-list">
                <li><a href="{{ route('admin.settings.account') }}">Admin login credentials</a></li>
                <li><a href="{{ route('admin.users.index') }}">User accounts</a></li>
                <li><a href="{{ route('admin.settings.payments') }}">Payment settings</a></li>
                <li><a href="{{ route('home') }}">View live site</a></li>
            </ul>
        </section>
    </div>

    <section class="admin-panel mt-8">
        <h2 class="admin-panel-title">Recent orders</h2>
        <div class="mt-4 overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr class="border-t border-gray-100">
                            <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-primary hover:underline">{{ $order->order_number }}</a></td>
                            <td class="px-4 py-3">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3">{{ $order->formattedTotal() }}</td>
                            <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
