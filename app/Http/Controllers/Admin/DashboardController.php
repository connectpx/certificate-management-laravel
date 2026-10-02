<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Comment;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'certificates' => Certificate::query()->count(),
                'active_certificates' => Certificate::query()->active()->count(),
                'users' => User::query()->count(),
                'pending_comments' => Comment::query()->where('status', Comment::STATUS_PENDING)->count(),
            ],
            'recentCertificates' => Certificate::query()->latest()->limit(5)->get(),
        ]);
    }
}
