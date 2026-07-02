<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiFeedback;
use App\Services\Ai\AiManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AiChatController extends Controller
{
    protected AiManagerService $aiManager;

    public function __construct(AiManagerService $aiManager)
    {
        $this->aiManager = $aiManager;
    }

    public function index(Request $request): View
    {
        $role = Auth::user()->role->slug ?? 'patient';
        
        $conversations = AiConversation::where('user_id', Auth::id())
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $activeConversation = null;
        if ($request->has('conversation_id')) {
            $activeConversation = AiConversation::with('messages')
                ->where('user_id', Auth::id())
                ->findOrFail($request->input('conversation_id'));
        } elseif ($conversations->isNotEmpty()) {
            $activeConversation = AiConversation::with('messages')
                ->where('user_id', Auth::id())
                ->orderBy('is_pinned', 'desc')
                ->orderBy('updated_at', 'desc')
                ->first();
        }

        return view('ai.chat', compact('conversations', 'activeConversation', 'role'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'nullable|exists:ai_conversations,id',
        ]);

        $messageText = $request->input('message');
        $conversationId = $request->input('conversation_id');

        if (!$conversationId) {
            $conversation = AiConversation::create([
                'user_id' => Auth::id(),
                'title' => substr($messageText, 0, 30) . '...',
                'role' => Auth::user()->role->slug ?? 'patient',
                'is_pinned' => false,
            ]);
            $conversationId = $conversation->id;
        } else {
            $conversation = AiConversation::findOrFail($conversationId);
        }

        // 1. Create User Message
        $userMessage = AiMessage::create([
            'conversation_id' => $conversationId,
            'sender_role' => 'user',
            'message_content' => $messageText,
        ]);

        // 2. Fetch all previous messages in conversation for context
        $history = AiMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role' => $m->sender_role === 'user' ? 'user' : 'assistant',
                'content' => $m->message_content,
            ])
            ->toArray();

        // 3. Generate AI Response
        $aiRes = $this->aiManager->generateResponse($history);

        // 4. Create AI Message
        $aiMessage = AiMessage::create([
            'conversation_id' => $conversationId,
            'sender_role' => 'ai',
            'message_content' => $aiRes['text'],
            'token_count' => $aiRes['prompt_tokens'] + $aiRes['completion_tokens'],
            'latency_ms' => $aiRes['latency_ms'],
        ]);

        $conversation->touch();

        return response()->json([
            'success' => true,
            'conversation_id' => $conversationId,
            'user_message' => $userMessage,
            'ai_message' => $aiMessage,
        ]);
    }

    public function feedback(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'rating' => 'required|in:1,-1',
            'comments' => 'nullable|string',
        ]);

        $feedback = AiFeedback::updateOrCreate(
            ['ai_message_id' => $id],
            [
                'rating' => $request->input('rating'),
                'comments' => $request->input('comments'),
                'corrected_by_user_id' => Auth::id(),
            ]
        );

        return response()->json(['success' => true, 'feedback' => $feedback]);
    }
}
