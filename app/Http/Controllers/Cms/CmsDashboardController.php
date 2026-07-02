<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\BlogPost;
use App\Models\NewsArticle;
use App\Models\NewsletterSubscriber;
use App\Models\ContactMessage;
use App\Models\MediaLibrary;
use App\Models\SeoMetadata;
use Illuminate\View\View;

class CmsDashboardController extends Controller
{
    public function index(): View
    {
        $publishedCount = CmsPage::where('is_published', true)->count();
        $draftCount = CmsPage::where('is_published', false)->count();
        $blogPostsCount = BlogPost::count();
        $newsletterCount = NewsletterSubscriber::count();
        $messagesCount = ContactMessage::count();
        
        // Mock analytics metric
        $mediaCount = 142; // Simulated file uploads count
        $seoScore = 98; // Simulated aggregate Google lighthouse/SEO checklist score
        
        return view('cms.dashboard', compact(
            'publishedCount',
            'draftCount',
            'blogPostsCount',
            'newsletterCount',
            'messagesCount',
            'mediaCount',
            'seoScore'
        ));
    }
}
