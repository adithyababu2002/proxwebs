<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterConfirmationMail;
use App\Mail\NewsletterNotificationMail;
use App\Models\NewsletterSubscriber;
use App\Models\VisitorSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:190'],
            'source' => ['nullable', 'string', 'max:40'],
            'visitor_uuid' => ['nullable', 'uuid'],
        ]);

        $email = strtolower(trim($validated['email']));

        if (! empty($validated['visitor_uuid'])) {
            VisitorSession::query()
                ->where('visitor_uuid', $validated['visitor_uuid'])
                ->update([
                    'email' => $email,
                    'last_seen_at' => now(),
                ]);
        }

        $existing = NewsletterSubscriber::where('email', $email)->first();
        if ($existing) {
            return response()->json([
                'message' => 'You are already subscribed. Thanks for staying with us!',
                'subscriber_id' => $existing->id,
            ]);
        }

        $subscriber = NewsletterSubscriber::create([
            'email' => $email,
            'source' => $validated['source'] ?? 'footer',
        ]);

        $adminEmail = config('mail.contact_admin');

        try {
            Mail::to($subscriber->email)->send(new NewsletterConfirmationMail($subscriber));

            if (! empty($adminEmail)) {
                Mail::to($adminEmail)->send(new NewsletterNotificationMail($subscriber));
            }
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'You are subscribed, but confirmation email delivery failed.',
                'subscriber_id' => $subscriber->id,
            ], 202);
        }

        return response()->json([
            'message' => 'Thanks for subscribing! Check your inbox for a confirmation.',
            'subscriber_id' => $subscriber->id,
        ]);
    }
}
