@include('components.footer-features')

<x-newsletter-band />

<footer class="border-t border-gray-200 bg-white">
    <div class="container-site py-10">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <img src="{{ asset('images/brand/logo.png') }}" alt="{{ config('app.name') }}" class="mb-3 h-12 w-auto">
                <p class="text-sm leading-relaxed text-gray-600">
                    Camera, lens, lighting and production gear for rent in Kumasi, Ghana.
                </p>
                <p class="mt-3 text-sm text-gray-600">
                    <a href="tel:{{ config('site.contact.phone') }}" class="hover:text-primary">{{ config('site.contact.phone_display') }}</a><br>
                    <a href="mailto:{{ config('site.contact.support_email') }}" class="hover:text-primary">{{ config('site.contact.support_email') }}</a>
                </p>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold text-gray-900">Company</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('about') }}" class="hover:text-primary">About</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold text-gray-900">Customer Service</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('help') }}" class="hover:text-primary">Help Center</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-primary">FAQs</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary">Locate Us</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold text-gray-900">Policies</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('privacy') }}" class="hover:text-primary">Privacy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-primary">Terms &amp; conditions</a></li>
                </ul>
            </div>
        </div>
        <p class="mt-8 border-t border-gray-200 pt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
    </div>
</footer>
