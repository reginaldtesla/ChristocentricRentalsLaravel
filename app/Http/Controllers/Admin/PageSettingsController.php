<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\PageContent;
use App\Support\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageSettingsController extends Controller
{
    /** @var list<string> */
    private const PAGES = ['about', 'faq', 'help', 'terms', 'privacy'];

    public function index()
    {
        return view('admin.settings.pages.index', [
            'pages' => [
                'about' => 'About',
                'faq' => 'FAQ',
                'help' => 'Help & Support',
                'terms' => 'Terms & Conditions',
                'privacy' => 'Privacy Policy',
            ],
        ]);
    }

    public function edit(string $page)
    {
        abort_unless(in_array($page, self::PAGES, true), 404);

        return view('admin.settings.pages.edit', [
            'page' => $page,
            'pageTitle' => match ($page) {
                'about' => 'About',
                'faq' => 'FAQ',
                'help' => 'Help & Support',
                'terms' => 'Terms & Conditions',
                'privacy' => 'Privacy Policy',
            },
            'content' => PageContent::get($page),
            'defaultBody' => in_array($page, ['help', 'terms', 'privacy'], true)
                ? PageContent::defaultBodyHtml($page)
                : null,
        ]);
    }

    public function update(Request $request, string $page)
    {
        abort_unless(in_array($page, self::PAGES, true), 404);

        $validated = match ($page) {
            'about' => $this->validateAbout($request),
            'faq' => $this->validateFaq($request),
            default => $this->validateDocument($request, $page),
        };

        SiteConfig::save("page_{$page}", $validated);

        return redirect()
            ->route('admin.settings.pages.edit', $page)
            ->with('success', 'Page content updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateAbout(Request $request): array
    {
        return $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'intro' => ['required', 'string', 'max:2000'],
            'sections' => ['required', 'array', 'min:1', 'max:10'],
            'sections.*.heading' => ['required', 'string', 'max:255'],
            'sections.*.body' => ['required', 'string', 'max:2000'],
            'bullets_heading' => ['required', 'string', 'max:255'],
            'bullets' => ['required', 'array', 'min:1', 'max:20'],
            'bullets.*' => ['required', 'string', 'max:500'],
            'cta_text' => ['required', 'string', 'max:100'],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateFaq(Request $request): array
    {
        return $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.q' => ['required', 'string', 'max:500'],
            'items.*.a' => ['required', 'string', 'max:2000'],
            'footer_note' => ['required', 'string', 'max:500'],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateDocument(Request $request, string $page): array
    {
        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'effective_date' => [Rule::requiredIf(in_array($page, ['terms', 'privacy'], true)), 'nullable', 'string', 'max:50'],
            'body_html' => ['nullable', 'string', 'max:65000'],
        ]);

        $validated['toc'] = PageContent::get($page)['toc'] ?? [];

        return $validated;
    }
}
