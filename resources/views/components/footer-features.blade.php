<section class="border-t border-gray-200 bg-gray-50 py-6">
    <div class="container-site">
        <div class="grid gap-4 text-center sm:grid-cols-2 lg:grid-cols-4 lg:text-left">
            @foreach (config('site.footer_features') as $feature)
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $feature['title'] }}</p>
                    <p class="mt-0.5 text-sm text-gray-600">{{ $feature['subtitle'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
