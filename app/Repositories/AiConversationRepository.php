<?php

namespace App\Repositories;

use App\Models\AiConversation;
use Illuminate\Database\Eloquent\Collection;

class AiConversationRepository
{
    public function getConversationsForUser(int $userId, string $role): Collection
    {
        return AiConversation::where('user_id', $userId)
            ->where('role', $role)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
