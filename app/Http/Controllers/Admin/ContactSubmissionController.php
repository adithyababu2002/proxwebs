<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $submissions = ContactSubmission::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json($submissions);
    }

    public function show(ContactSubmission $contact): JsonResponse
    {
        return response()->json([
            'data' => $contact,
        ]);
    }

    public function destroy(ContactSubmission $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact submission deleted.',
        ]);
    }
}
