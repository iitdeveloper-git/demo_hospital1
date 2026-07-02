<?php

namespace App\Services\Ai\Contracts;

interface AiProviderInterface
{
    /**
     * Send messages to the provider and return the response.
     *
     * @param array $messages Array of message associative arrays: [['role' => 'user', 'content' => '...']]
     * @param array $options Model parameters like temperature, max_tokens, etc.
     * @return array Response payload: ['text' => '...', 'prompt_tokens' => X, 'completion_tokens' => Y, 'latency_ms' => Z]
     */
    public function generate(array $messages, array $options = []): array;
}
