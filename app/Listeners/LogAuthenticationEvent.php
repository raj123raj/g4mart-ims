<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogAuthenticationEvent
{
    public function __construct(private Request $request)
    {
    }

    public function handle(Login|Logout $event): void
    {
        $user = $event->user;

        AuditLog::create([
            'user_id' => $user->id,
            'action' => $event instanceof Login ? 'auth.login' : 'auth.logout',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->id,
            'old_values' => null,
            'new_values' => null,
            'ip_address' => $this->request->ip(),
            'user_agent' => substr((string) $this->request->userAgent(), 0, 1000),
            'created_at' => now(),
        ]);
    }
}
