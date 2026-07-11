<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $subscribers = NewsletterSubscriber::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('email', 'like', "%{$search}%")
                    ->orWhere('source', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json($subscribers);
    }

    public function destroy(NewsletterSubscriber $subscriber): JsonResponse
    {
        $subscriber->delete();

        return response()->json([
            'message' => 'Subscriber removed.',
        ]);
    }
}
