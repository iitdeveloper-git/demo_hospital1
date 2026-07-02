<?php

namespace App\Traits;

trait GeneratesReferenceNumbers
{
    protected function reference(string $prefix): string
    {
        return $prefix.'-'.now()->format('ymd').'-'.strtoupper(str()->random(6));
    }
}
