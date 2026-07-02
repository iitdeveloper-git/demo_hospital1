<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\RedirectRule;
use App\Models\WebsiteSetting;
use App\Services\Cms\SeoManagerService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SeoController extends Controller
{
    protected SeoManagerService $seoService;

    public function __construct(SeoManagerService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function seo(): View
    {
        $redirects = RedirectRule::paginate(15);
        return view('cms.seo', compact('redirects'));
    }

    public function storeRedirect(Request $request): RedirectResponse
    {
        $request->validate([
            'old_slug' => 'required|string|unique:redirect_rules,old_slug',
            'new_slug' => 'required|string',
        ]);

        RedirectRule::create([
            'old_slug' => $request->input('old_slug'),
            'new_slug' => $request->input('new_slug'),
            'status_code' => 301,
        ]);

        return redirect()->back()->with('success', '301 Redirect rule registered successfully.');
    }

    public function settings(): View
    {
        $settings = WebsiteSetting::all();
        return view('cms.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'hospital_logo' => 'nullable|string',
            'favicon' => 'nullable|string',
            'business_hours' => 'nullable|string',
        ]);

        foreach ($request->only(['hospital_logo', 'favicon', 'business_hours']) as $key => $val) {
            WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        return redirect()->back()->with('success', 'Global website settings updated successfully.');
    }
}
