<?php

namespace App\Services\Ai;

use App\Models\AiProviderSetting;
use App\Models\AiUsageLog;
use App\Services\Ai\Providers\MockAiProvider;
use App\Services\Ai\Providers\GeminiProvider;
use App\Services\Ai\Providers\OpenAiProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AiManagerService
{
    public function getProvider(string $providerName)
    {
        switch ($providerName) {
            case 'gemini':
                return new GeminiProvider();
            case 'openai':
                return new OpenAiProvider();
            case 'mock':
            default:
                return new MockAiProvider();
        }
    }

    public function generateResponse(array $messages, array $options = []): array
    {
        // 1. Fetch active provider setting
        $activeSetting = AiProviderSetting::where('is_active', true)->first();
        $providerName = $activeSetting ? $activeSetting->provider : 'mock';
        $model = $activeSetting ? $activeSetting->model : 'mock';
        $temperature = $activeSetting ? $activeSetting->temperature : 0.7;

        $options = array_merge([
            'model' => $model,
            'temperature' => $temperature,
        ], $options);

        try {
            $provider = $this->getProvider($providerName);
            $res = $provider->generate($messages, $options);
            
            // Log success to audit trail
            $this->logUsage($providerName, $model, $res['prompt_tokens'], $res['completion_tokens'], $res['latency_ms']);

            return $res;
        } catch (\Throwable $e) {
            Log::warning("AI Provider {$providerName} failed: " . $e->getMessage() . ". Attempting fallback.");

            // Attempt fallback strategy
            $fallback = $activeSetting ? $activeSetting->fallback_strategy : 'mock';
            try {
                $fallbackProvider = $this->getProvider($fallback);
                $res = $fallbackProvider->generate($messages, $options);
                
                $this->logUsage($fallback, $options['model'] ?? 'fallback', $res['prompt_tokens'], $res['completion_tokens'], $res['latency_ms']);
                return $res;
            } catch (\Throwable $ex) {
                // If fallback also fails, use Mock as absolute fallback
                Log::error("AI Fallback provider {$fallback} also failed: " . $ex->getMessage());
                $mock = new MockAiProvider();
                $res = $mock->generate($messages, $options);
                
                $this->logUsage('mock', 'mock-emergency-fallback', $res['prompt_tokens'], $res['completion_tokens'], $res['latency_ms'], $ex->getMessage());
                return $res;
            }
        }
    }

    private function logUsage(string $provider, string $model, int $promptTokens, int $completionTokens, int $latencyMs, ?string $error = null): void
    {
        try {
            AiUsageLog::create([
                'user_id' => Auth::id(),
                'provider' => $provider,
                'model' => $model,
                'prompt_tokens' => $promptTokens,
                'completion_tokens' => $completionTokens,
                'latency_ms' => $latencyMs,
                'cost' => ($promptTokens * 0.000002) + ($completionTokens * 0.000008), // mock estimation
                'error_message' => $error,
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to log AI usage metrics: " . $e->getMessage());
        }
    }
}
