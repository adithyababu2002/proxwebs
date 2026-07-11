<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitorLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $sessions = VisitorSession::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('landing_page', 'like', "%{$search}%");
                });
            })
            ->latest('last_seen_at')
            ->paginate(20)
            ->withQueryString();

        $sessions->setCollection(
            $sessions->getCollection()->map(fn (VisitorSession $session) => $session->toAdminArray())
        );

        return response()->json($sessions);
    }

    public function show(VisitorSession $log): JsonResponse
    {
        $log->load([
            'pageViews' => fn ($q) => $q->orderByDesc('started_at'),
            'events' => fn ($q) => $q->orderByDesc('occurred_at'),
        ]);

        return response()->json([
            'data' => [
                ...$log->toAdminArray(),
                'user_agent' => $log->user_agent,
                'page_views' => $log->pageViews->map(fn ($view) => [
                    'id' => $view->id,
                    'path' => $view->path,
                    'title' => $view->title,
                    'started_at' => $view->started_at,
                    'ended_at' => $view->ended_at,
                    'duration_seconds' => $view->duration_seconds,
                ]),
                'events' => $log->events->map(fn ($event) => [
                    'id' => $event->id,
                    'type' => $event->type,
                    'path' => $event->path,
                    'label' => $event->label,
                    'meta' => $event->meta,
                    'occurred_at' => $event->occurred_at,
                ]),
            ],
        ]);
    }

    public function destroy(VisitorSession $log): JsonResponse
    {
        $log->delete();

        return response()->json([
            'message' => 'Visitor log deleted.',
        ]);
    }
}
