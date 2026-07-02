<?php

namespace App\Services\Cms;

use App\Models\SeoMetadata;
use App\Models\RedirectRule;
use Illuminate\Support\Facades\Request;

class SeoManagerService
{
    public function generateSitemapXml(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= '<url><loc>' . url('/') . '</loc><priority>1.0</priority></url>';
        $xml .= '<url><loc>' . url('/about') . '</loc><priority>0.8</priority></url>';
        $xml .= '<url><loc>' . url('/services') . '</loc><priority>0.8</priority></url>';
        $xml .= '</urlset>';
        return $xml;
    }

    public function handleRedirect(string $slug): ?string
    {
        $rule = RedirectRule::where('old_slug', $slug)->first();
        return $rule ? $rule->new_slug : null;
    }

    public function getMetaForRequest(string $path): array
    {
        // Simple metadata fallback helper
        return [
            'title' => 'Healthcare Services & Treatments | AarogyaCare',
            'description' => 'Explore our range of premium, advanced medical services spanning Cardiology, Neurology, Orthopedics, and more.',
            'canonical' => url($path),
        ];
    }
}
