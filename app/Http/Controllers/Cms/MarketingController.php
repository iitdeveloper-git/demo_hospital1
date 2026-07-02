<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\MarketingCampaign;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MarketingController extends Controller
{
    public function newsletter(): View
    {
        $subscribers = NewsletterSubscriber::paginate(20);
        return view('cms.newsletter', compact('subscribers'));
    }

    public function campaigns(): View
    {
        $campaigns = MarketingCampaign::paginate(15);
        return view('cms.campaigns', compact('campaigns'));
    }

    public function storeCampaign(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'channel' => 'required|in:email,sms,whatsapp,push',
            'template_content' => 'required|string',
        ]);

        MarketingCampaign::create([
            'name' => $request->input('name'),
            'channel' => $request->input('channel'),
            'template_content' => $request->input('template_content'),
            'status' => 'scheduled',
            'schedule_at' => now()->addHour(),
        ]);

        return redirect()->back()->with('success', 'Marketing campaign scheduled successfully.');
    }

    public function contactMessages(): View
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        return view('cms.contact-messages', compact('messages'));
    }
}
