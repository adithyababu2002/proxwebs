<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $contactsTotal = ContactSubmission::count();
        $subscribersTotal = NewsletterSubscriber::count();
        $teamTotal = TeamMember::count();
        $usersTotal = User::count();

        return response()->json([
            'stats' => [
                'contacts_total' => $contactsTotal,
                'contacts_today' => ContactSubmission::whereDate('created_at', today())->count(),
                'contacts_week' => ContactSubmission::where('created_at', '>=', now()->subDays(7))->count(),
                'subscribers_total' => $subscribersTotal,
                'subscribers_today' => NewsletterSubscriber::whereDate('created_at', today())->count(),
                'subscribers_week' => NewsletterSubscriber::where('created_at', '>=', now()->subDays(7))->count(),
                'team_total' => $teamTotal,
                'team_active' => TeamMember::where('is_active', true)->count(),
                'users_total' => $usersTotal,
            ],
            'recent_contacts' => ContactSubmission::query()
                ->latest()
                ->limit(5)
                ->get(['id', 'name', 'email', 'phone', 'source', 'created_at']),
            'recent_subscribers' => NewsletterSubscriber::query()
                ->latest()
                ->limit(5)
                ->get(['id', 'email', 'source', 'created_at']),
            'recent_team' => TeamMember::query()
                ->orderByDesc('updated_at')
                ->limit(5)
                ->get()
                ->map(fn (TeamMember $member) => $member->toAdminArray())
                ->values(),
        ]);
    }
}
