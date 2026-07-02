<?php

namespace App\Services\Ai\Providers;

use App\Services\Ai\Contracts\AiProviderInterface;
use Illuminate\Support\Facades\Http;

class OpenAiProvider implements AiProviderInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY', '');
    }

    public function generate(array $messages, array $options = []): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception("OpenAI API Key is not configured in env.");
        }

        $model = $options['model'] ?? 'gpt-4o-mini';
        $temperature = $options['temperature'] ?? 0.7;

        $start = microtime(true);
        
        $response = Http::withToken($this->apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => (float)$temperature,
            ]);

        $latency = (int)((microtime(true) - $start) * 1000);

        if ($response->failed()) {
            throw new \Exception("OpenAI API error: " . $response->body());
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';
        $promptTokens = $data['usage']['prompt_tokens'] ?? 0;
        $completionTokens = $data['usage']['completion_tokens'] ?? 0;

        return [
            'text' => $text,
            'prompt_tokens' => $promptTokens,
            'completion_tokens' => $completionTokens,
            'latency_ms' => $latency,
        ];
    }
}
