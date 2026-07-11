<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function index(): JsonResponse
    {
        $members = TeamMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (TeamMember $member) => $member->toPublicArray())
            ->values();

        return response()->json([
            'data' => $members,
        ]);
    }
}
