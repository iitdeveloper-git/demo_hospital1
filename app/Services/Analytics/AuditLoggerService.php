<?php

namespace App\Services\Analytics;

use App\Models\AuditEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLoggerService
{
    public function log(string $action, string $module, ?array $oldValues = null, ?array $newValues = null): void
    {
        AuditEvent::create([
            'session_id' => session()->getId(),
            'user_id' => Auth::id(),
            'action' => $action,
            'affected_module' => $module,
            'ip_address' => Request::ip(),
            'browser' => Request::header('User-Agent'),
            'old_values_json' => $oldValues,
            'new_values_json' => $newValues,
        ]);
    }
}
