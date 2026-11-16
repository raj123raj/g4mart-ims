<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest('created_at');

        if ($request->filled('action')) {
            $query->where('action', 'like', '%'.$request->string('action').'%');
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('audit-logs.index', compact('logs'));
    }
}
