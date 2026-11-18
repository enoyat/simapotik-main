<?php

namespace App\Listeners;

use App\Models\LoginHistory;
use Illuminate\Auth\Events\Login;

class RecordLoginHistory
{
    public function handle(Login $event)
    {
        $user = $event->user;

        LoginHistory::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'username' => $user->email,
            'branch_id' => !empty($user->branch_id) && $user->branch_id > 0
                ? $user->branch_id
                : null,
            'event' => 'LOGIN',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => request()->hasSession()
                ? request()->session()->getId()
                : null,
            'occurred_at' => now(),
        ]);
    }
}
