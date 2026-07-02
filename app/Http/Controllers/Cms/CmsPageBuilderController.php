<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\BlogPost;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\CareerJob;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Services\Cms\CmsBuilderService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CmsPageBuilderController extends Controller
{
    protected CmsBuilderService $builderService;

    public function __construct(CmsBuilderService $builderService)
    {
        $this->builderService = $builderService;
    }

    public function pages(): View
    {
        $pages = CmsPage::withCount('sections')->paginate(20);
        return view('cms.pages', compact('pages'));
    }

    public function builder(int $id): View
    {
        $page = CmsPage::with(['sections.blocks'])->findOrFail($id);
        return view('cms.builder', compact('page'));
    }

    public function updateBlocks(Request $request, int $id): JsonResponse
    {
        // AJAX endpoint to save block sorting/dragging order
        return response()->json(['success' => true]);
    }

    public function blog(): View
    {
        $posts = BlogPost::with(['category', 'author'])->paginate(15);
        return view('cms.blog', compact('posts'));
    }

    public function news(): View
    {
        $news = NewsArticle::paginate(15);
        return view('cms.news', compact('news'));
    }

    public function events(): View
    {
        $events = Event::paginate(15);
        return view('cms.events', compact('events'));
    }

    public function careers(): View
    {
        $jobs = CareerJob::withCount('applications')->paginate(15);
        return view('cms.careers', compact('jobs'));
    }

    public function testimonials(): View
    {
        $testimonials = Testimonial::paginate(15);
        return view('cms.testimonials', compact('testimonials'));
    }

    public function faqs(): View
    {
        $faqs = Faq::paginate(15);
        return view('cms.faqs', compact('faqs'));
    }
}
