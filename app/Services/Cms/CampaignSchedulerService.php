<?php

namespace App\Services\Cms;

use App\Models\MarketingCampaign;

class CampaignSchedulerService
{
    public function dispatchCampaign(int $campaignId): void
    {
        $campaign = MarketingCampaign::findOrFail($campaignId);
        // Simulate email queue processing
        $campaign->update(['status' => 'sent']);
    }
}
