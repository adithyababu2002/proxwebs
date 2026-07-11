<?php

namespace App\Http\Controllers;

use App\Models\VisitorEvent;
use App\Models\VisitorPageView;
use App\Models\VisitorSession;
use App\Services\VisitorGeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
    public function __construct(private readonly VisitorGeoService $geo)
    {
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_uuid' => ['nullable', 'uuid'],
            'path' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'referrer' => ['nullable', 'string', 'max:500'],
            'duration_seconds' => ['nullable', 'integer', 'min:0', 'max:86400'],
            'page_view_id' => ['nullable', 'integer'],
            'is_new_page' => ['sometimes', 'boolean'],
        ]);

        if ($this->shouldIgnorePath($data['path'])) {
            return response()->json(['ignored' => true]);
        }

        $session = $this->resolveSession($request, $data['visitor_uuid'] ?? null, $data);

        $pageView = null;
        $isNewPage = $request->boolean('is_new_page', false);

        if (! empty($data['page_view_id'])) {
            $pageView = VisitorPageView::query()
                ->where('visitor_session_id', $session->id)
                ->whereKey($data['page_view_id'])
                ->first();
        }

        if ($isNewPage || ! $pageView) {
            if ($pageView && isset($data['duration_seconds'])) {
                $this->closePageView($pageView, (int) $data['duration_seconds']);
            }

            $pageView = VisitorPageView::query()->create([
                'visitor_session_id' => $session->id,
                'path' => $data['path'],
                'title' => $data['title'] ?? null,
                'started_at' => now(),
                'duration_seconds' => 0,
            ]);

            $session->increment('page_views_count');
        } elseif (isset($data['duration_seconds'])) {
            $duration = max((int) $pageView->duration_seconds, (int) $data['duration_seconds']);
            $pageView->update([
                'duration_seconds' => $duration,
                'title' => $data['title'] ?? $pageView->title,
                'ended_at' => now(),
            ]);
        }

        $session->update([
            'last_seen_at' => now(),
            'total_duration_seconds' => (int) $session->pageViews()->sum('duration_seconds'),
        ]);

        return response()->json([
            'visitor_uuid' => $session->visitor_uuid,
            'page_view_id' => $pageView->id,
        ]);
    }

    public function event(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_uuid' => ['nullable', 'uuid'],
            'type' => ['required', 'string', 'max:60'],
            'path' => ['nullable', 'string', 'max:255'],
            'label' => ['nullable', 'string', 'max:255'],
            'meta' => ['nullable', 'array'],
        ]);

        if (! empty($data['path']) && $this->shouldIgnorePath($data['path'])) {
            return response()->json(['ignored' => true]);
        }

        $session = $this->resolveSession($request, $data['visitor_uuid'] ?? null, [
            'path' => $data['path'] ?? '/',
            'referrer' => null,
        ]);

        VisitorEvent::query()->create([
            'visitor_session_id' => $session->id,
            'type' => $data['type'],
            'path' => $data['path'] ?? null,
            'label' => $data['label'] ?? null,
            'meta' => $data['meta'] ?? null,
            'occurred_at' => now(),
        ]);

        $session->increment('events_count');
        $session->update(['last_seen_at' => now()]);

        return response()->json([
            'visitor_uuid' => $session->visitor_uuid,
            'ok' => true,
        ]);
    }

    public function identify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_uuid' => ['nullable', 'uuid'],
            'email' => ['required', 'email', 'max:190'],
            'name' => ['nullable', 'string', 'max:120'],
            'source' => ['nullable', 'string', 'max:60'],
            'path' => ['nullable', 'string', 'max:255'],
        ]);

        $session = $this->resolveSession($request, $data['visitor_uuid'] ?? null, [
            'path' => $data['path'] ?? '/',
            'referrer' => null,
        ]);

        $session->update([
            'email' => strtolower(trim($data['email'])),
            'name' => $data['name'] ?? $session->name,
            'last_seen_at' => now(),
        ]);

        VisitorEvent::query()->create([
            'visitor_session_id' => $session->id,
            'type' => 'identify',
            'path' => $data['path'] ?? null,
            'label' => $data['source'] ?? 'form',
            'meta' => [
                'email' => $session->email,
                'name' => $session->name,
            ],
            'occurred_at' => now(),
        ]);

        $session->increment('events_count');

        return response()->json([
            'visitor_uuid' => $session->visitor_uuid,
            'ok' => true,
        ]);
    }

    private function resolveSession(Request $request, ?string $uuid, array $context): VisitorSession
    {
        $uuid = $uuid && Str::isUuid($uuid) ? $uuid : (string) Str::uuid();

        $session = VisitorSession::query()->where('visitor_uuid', $uuid)->first();

        if ($session) {
            return $session;
        }

        $geo = $this->geo->locate($request);
        $ua = $this->geo->parseUserAgent($request->userAgent());

        return VisitorSession::query()->create([
            'visitor_uuid' => $uuid,
            'ip_address' => $geo['ip_address'] ?? $request->ip(),
            'country' => $geo['country'] ?? null,
            'region' => $geo['region'] ?? null,
            'city' => $geo['city'] ?? null,
            'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
            'browser' => $ua['browser'],
            'platform' => $ua['platform'],
            'device' => $ua['device'],
            'landing_page' => $context['path'] ?? '/',
            'referrer' => $context['referrer'] ?? null,
            'first_seen_at' => now(),
            'last_seen_at' => now(),
        ]);
    }

    private function closePageView(VisitorPageView $pageView, int $durationSeconds): void
    {
        $pageView->update([
            'duration_seconds' => max((int) $pageView->duration_seconds, $durationSeconds),
            'ended_at' => now(),
        ]);
    }

    private function shouldIgnorePath(string $path): bool
    {
        $path = '/'.ltrim($path, '/');

        return str_starts_with($path, '/webuser')
            || str_starts_with($path, '/admin');
    }
}
