@extends('layouts.app')

@section('title', 'My Orders — ' . config('app.name'))

@section('content')
    <x-pages.hero title="My Orders" subtitle="Track your rental bookings." />

    <div class="container-site py-10">
        @include('account._nav')

        @if ($orders->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-12 text-center">
                <p class="text-gray-600">You have no orders yet.</p>
                <a href="{{ route('shop') }}" class="btn-solid mt-6">Start Renting</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="block rounded-2xl border border-gray-200 bg-white p-6 transition hover:shadow-md">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary">{{ $order->formattedTotal() }}</p>
                                <p class="text-sm capitalize text-gray-500">{{ $order->status }} · {{ $order->payment_status }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $orders->links() }}</div>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Log out</button>
        </form>
    </div>
@endsection
