<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminImageStore;
use App\Support\SiteConfig;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function contact()
    {
        return view('admin.settings.contact', [
            'contact' => config('site.contact'),
        ]);
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'support_email' => ['required', 'email', 'max:255'],
            'feedback_email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'phone_display' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        SiteConfig::save('contact', $validated);

        return back()->with('success', 'Contact details updated.');
    }

    public function newsletter()
    {
        return view('admin.settings.newsletter', [
            'newsletter' => config('site.newsletter'),
        ]);
    }

    public function updateNewsletter(Request $request)
    {
        $validated = $request->validate([
            'eyebrow' => ['required', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:255'],
            'subtext' => ['required', 'string', 'max:1000'],
            'button' => ['required', 'string', 'max:100'],
            'privacy_note' => ['required', 'string', 'max:255'],
            'founder_name' => ['required', 'string', 'max:255'],
            'founder_role' => ['required', 'string', 'max:255'],
            'founder_quote' => ['required', 'string', 'max:2000'],
            'founder_avatar' => ['required', 'string', 'max:255'],
            ...AdminImageStore::rules('founder_avatar_file'),
        ]);

        if ($request->hasFile('founder_avatar_file')) {
            $validated['founder_avatar'] = AdminImageStore::store(
                $request->file('founder_avatar_file'),
                'uploads/newsletter',
            );
        }

        SiteConfig::save('newsletter', $validated);

        return back()->with('success', 'Newsletter section updated.');
    }

    public function homepage()
    {
        return view('admin.settings.homepage', [
            'heroSlides' => config('site.hero_slides'),
            'dealsSlides' => config('site.deals_slides'),
            'brandBanners' => config('site.brand_banners'),
            'weeklyDeals' => config('site.weekly_deals'),
            'featuredLighting' => config('site.featured_lighting'),
        ]);
    }

    public function updateHomepage(Request $request)
    {
        $validated = $request->validate([
            'hero_slides' => ['required', 'array', 'min:1', 'max:12'],
            'hero_slides.*.subtitle' => ['required', 'string', 'max:100'],
            'hero_slides.*.title' => ['required', 'string', 'max:255'],
            'hero_slides.*.description' => ['required', 'string', 'max:500'],
            'hero_slides.*.image' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:5120'],
            'hero_slides.*.cta_primary' => ['required', 'string', 'max:100'],
            'hero_slides.*.cta_url' => ['required', 'string', 'max:255'],
            'deals_slides' => ['required', 'array', 'min:1', 'max:12'],
            'deals_slides.*.badge' => ['required', 'string', 'max:100'],
            'deals_slides.*.title' => ['required', 'string', 'max:255'],
            'deals_slides.*.before' => ['nullable', 'string', 'max:500'],
            'deals_slides.*.image' => ['nullable', 'string', 'max:255'],
            'deals_slides.*.image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:5120'],
            'deals_slides.*.url' => ['required', 'string', 'max:255'],
            'brand_banners' => ['required', 'array', 'min:1', 'max:12'],
            'brand_banners.*.title' => ['required', 'string', 'max:255'],
            'brand_banners.*.description' => ['required', 'string', 'max:255'],
            'brand_banners.*.image' => ['nullable', 'string', 'max:255'],
            'brand_banners.*.image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:5120'],
            'brand_banners.*.url' => ['required', 'string', 'max:255'],
            'weekly_deals' => ['required', 'array', 'min:1', 'max:12'],
            'weekly_deals.*.title' => ['required', 'string', 'max:255'],
            'weekly_deals.*.description' => ['required', 'string', 'max:500'],
            'weekly_deals.*.image' => ['nullable', 'string', 'max:255'],
            'weekly_deals.*.image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:5120'],
            'weekly_deals.*.url' => ['required', 'string', 'max:255'],
            'featured_lighting' => ['required', 'array', 'min:1', 'max:12'],
            'featured_lighting.*.title' => ['required', 'string', 'max:255'],
            'featured_lighting.*.description' => ['required', 'string', 'max:500'],
            'featured_lighting.*.image' => ['nullable', 'string', 'max:255'],
            'featured_lighting.*.image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:5120'],
        ]);

        $validated['hero_slides'] = AdminImageStore::applyImageUploads($request, $validated['hero_slides'], 'hero_slides', 'uploads/homepage/hero');
        $validated['deals_slides'] = AdminImageStore::applyImageUploads($request, $validated['deals_slides'], 'deals_slides', 'uploads/homepage/deals');
        $validated['brand_banners'] = AdminImageStore::applyImageUploads($request, $validated['brand_banners'], 'brand_banners', 'uploads/homepage/banners');
        $validated['weekly_deals'] = AdminImageStore::applyImageUploads($request, $validated['weekly_deals'], 'weekly_deals', 'uploads/homepage/picks');
        $validated['featured_lighting'] = AdminImageStore::applyImageUploads($request, $validated['featured_lighting'], 'featured_lighting', 'uploads/homepage/lighting');

        $this->assertHomepageImagesPresent($request, $validated);

        SiteConfig::save('hero_slides', array_values($validated['hero_slides']));
        SiteConfig::save('deals_slides', array_values($validated['deals_slides']));
        SiteConfig::save('brand_banners', array_values($validated['brand_banners']));
        SiteConfig::save('weekly_deals', array_values($validated['weekly_deals']));
        SiteConfig::save('featured_lighting', array_values($validated['featured_lighting']));

        return back()->with('success', 'Homepage content updated.');
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $validated
     */
    private function assertHomepageImagesPresent(Request $request, array $validated): void
    {
        $sections = [
            'hero_slides' => 'slide',
            'deals_slides' => 'highlight',
            'brand_banners' => 'category card',
            'weekly_deals' => 'staff pick',
            'featured_lighting' => 'lighting item',
        ];

        $errors = [];

        foreach ($sections as $key => $label) {
            foreach ($validated[$key] as $index => $item) {
                $hasImage = filled($item['image'] ?? null);
                $hasUpload = $request->hasFile("{$key}.{$index}.image_file");

                if (! $hasImage && ! $hasUpload) {
                    $errors["{$key}.{$index}.image_file"] = "Please upload a photo for {$label} ".($index + 1).'.';
                }
            }
        }

        if ($errors !== []) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }
    }

    public function footer()
    {
        return view('admin.settings.footer', [
            'trustFeatures' => config('site.trust_features'),
            'footerFeatures' => config('site.footer_features'),
            'brands' => implode(', ', config('site.brands', [])),
        ]);
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'trust_features' => ['required', 'array', 'size:4'],
            'trust_features.*.title' => ['required', 'string', 'max:255'],
            'trust_features.*.subtitle' => ['required', 'string', 'max:255'],
            'footer_features' => ['required', 'array', 'size:4'],
            'footer_features.*.title' => ['required', 'string', 'max:255'],
            'footer_features.*.subtitle' => ['required', 'string', 'max:255'],
            'brands' => ['required', 'string', 'max:2000'],
        ]);

        SiteConfig::save('trust_features', array_values($validated['trust_features']));
        SiteConfig::save('footer_features', array_values($validated['footer_features']));
        SiteConfig::save('brands', collect(explode(',', $validated['brands']))
            ->map(fn (string $brand) => trim($brand))
            ->filter()
            ->values()
            ->all());

        return back()->with('success', 'Footer & trust bar updated.');
    }

    public function payments()
    {
        return view('admin.settings.payments', [
            'demoMode' => (bool) config('payments.demo_mode', true),
            'currency' => config('payments.paystack.currency', 'GHS'),
            'paystackConfigured' => filled(config('payments.paystack.secret_key')),
            'pickupCashEnabled' => (bool) config('payments.pickup_cash.enabled', true),
        ]);
    }

    public function rental()
    {
        return view('admin.settings.rental', [
            'penalties' => config('site.rental_penalties'),
        ]);
    }

    public function updateRental(Request $request)
    {
        $validated = $request->validate([
            'grace_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'daily_rate_multiplier' => ['required', 'numeric', 'min:0', 'max:10'],
            'due_soon_hours' => ['required', 'integer', 'min:1', 'max:168'],
        ]);

        SiteConfig::save('rental_penalties', $validated);

        return back()->with('success', 'Rental penalty rules updated.');
    }
}
