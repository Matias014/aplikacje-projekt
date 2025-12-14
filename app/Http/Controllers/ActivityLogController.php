<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    public function index()
    {
        Gate::authorize('is-admin');
        $logs = ActivityLog::with('user')->orderByDesc('created_at')->paginate(50);
        return view('admin.logs.index', ['logs' => $logs]);
    }
}
