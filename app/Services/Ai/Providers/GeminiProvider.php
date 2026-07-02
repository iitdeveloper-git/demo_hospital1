<?php

namespace App\Services\Ai\Providers;

use App\Services\Ai\Contracts\AiProviderInterface;
use Illuminate\Support\Facades\Http;

class GeminiProvider implements AiProviderInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    public function generate(array $messages, array $options = []): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception("Gemini API Key is not configured in env.");
        }

        $model = $options['model'] ?? 'gemini-1.5-flash';
        $temperature = $options['temperature'] ?? 0.7;

        // Convert roles to gemini (user or model)
        $contents = [];
        foreach ($messages as $msg) {
            $role = $msg['role'] === 'user' ? 'user' : 'model';
            $contents[] = [
                'role' => $role,
                'parts' => [
                    ['text' => $msg['content']]
                ]
            ];
        }

        $start = microtime(true);
        
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}", [
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => (float)$temperature,
                ]
            ]);

        $latency = (int)((microtime(true) - $start) * 1000);

        if ($response->failed()) {
            throw new \Exception("Gemini API error: " . $response->body());
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return [
            'text' => $text,
            'prompt_tokens' => intval(strlen(json_encode($messages)) / 4),
            'completion_tokens' => intval(strlen($text) / 4),
            'latency_ms' => $latency,
        ];
    }
}
