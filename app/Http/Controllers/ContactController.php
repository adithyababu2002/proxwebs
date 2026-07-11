<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmationMail;
use App\Mail\ContactNotificationMail;
use App\Models\ContactSubmission;
use App\Models\VisitorSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:5000'],
            'source' => ['nullable', 'string', 'max:40'],
            'visitor_uuid' => ['nullable', 'uuid'],
        ]);

        $submission = ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'description' => $validated['description'],
            'source' => $validated['source'] ?? 'website',
        ]);

        if (! empty($validated['visitor_uuid'])) {
            VisitorSession::query()
                ->where('visitor_uuid', $validated['visitor_uuid'])
                ->update([
                    'email' => strtolower(trim($validated['email'])),
                    'name' => $validated['name'],
                    'last_seen_at' => now(),
                ]);
        }

        // Customer email comes from the form; admin inbox is a fixed address.
        $adminEmail = config('mail.contact_admin');

        try {
            Mail::to($submission->email)->send(new ContactConfirmationMail($submission));

            if (! empty($adminEmail)) {
                Mail::to($adminEmail)->send(new ContactNotificationMail($submission));
            }
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Your message was saved, but email delivery failed. We will still follow up.',
                'submission_id' => $submission->id,
            ], 202);
        }

        return response()->json([
            'message' => 'Thank you! Your message has been sent successfully.',
            'submission_id' => $submission->id,
        ]);
    }
}
