@extends('layouts.app')

@section('title', 'Contact — ' . config('app.name'))

@section('content')
    <x-pages.hero title="Contact Us" subtitle="Pickup, rentals, and support" />

    <div class="container-site py-10 md:py-12">
        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="mb-5 text-lg font-semibold text-gray-900">Get in touch</h2>
                <dl class="space-y-5 text-sm text-gray-600">
                    <div>
                        <dt class="font-medium text-gray-900">Pickup location</dt>
                        <dd class="mt-1">{{ config('site.contact.address') }}<br>{{ config('site.contact.city') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Phone</dt>
                        <dd class="mt-1">
                            <a href="tel:{{ config('site.contact.phone') }}" class="hover:text-primary">{{ config('site.contact.phone_display') }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Customer support</dt>
                        <dd class="mt-1">
                            <a href="mailto:{{ config('site.contact.support_email') }}" class="hover:text-primary">{{ config('site.contact.support_email') }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">General inquiries</dt>
                        <dd class="mt-1">
                            <a href="mailto:{{ config('site.contact.email') }}" class="hover:text-primary">{{ config('site.contact.email') }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Feedback</dt>
                        <dd class="mt-1">
                            <a href="mailto:{{ config('site.contact.feedback_email') }}" class="hover:text-primary">{{ config('site.contact.feedback_email') }}</a>
                        </dd>
                    </div>
                </dl>
                <p class="mt-6 text-sm text-gray-600">
                    We respond within 24 hours on business days.
                    <a href="{{ route('help') }}" class="text-primary hover:underline">Help &amp; Support guide</a>
                </p>
            </div>

            <form class="border border-gray-200 bg-white p-6" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Send a message</h2>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full rounded border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    </div>
                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full rounded border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    </div>
                    <div>
                        <label for="message" class="mb-1 block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full rounded border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-solid w-full">Send message</button>
                </div>
            </form>
        </div>
    </div>
@endsection
