<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $tenant_id = Auth::user()->tenant_id;

        // Fetch logs for this school, most recent first
        $logs = ActivityLog::with('user')
            ->where('tenant_id', $tenant_id)
            ->latest()
            ->paginate(30);

        return view('school_admin.settings.activity_log', compact('logs'));
    }

    // A helper method you can call from OTHER controllers to record an action
    public static function log($module, $action, $description)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'tenant_id' => Auth::user()->tenant_id,
                'user_id' => Auth::id(),
                'module' => $module,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
