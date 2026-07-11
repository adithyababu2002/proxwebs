<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamMemberController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $members = TeamMember::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $members->setCollection(
            $members->getCollection()->map(fn (TeamMember $member) => $member->toAdminArray())
        );

        return response()->json($members);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->resolveImage($request, null);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

        $member = TeamMember::query()->create($data);

        return response()->json([
            'message' => 'Team member created.',
            'data' => $member->toAdminArray(),
        ], 201);
    }

    public function show(TeamMember $teamMember): JsonResponse
    {
        return response()->json([
            'data' => $teamMember->toAdminArray(),
        ]);
    }

    public function update(Request $request, TeamMember $teamMember): JsonResponse
    {
        $data = $this->validated($request, $teamMember);
        $data['image'] = $this->resolveImage($request, $teamMember->image);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $teamMember->id);

        $teamMember->update($data);

        return response()->json([
            'message' => 'Team member updated.',
            'data' => $teamMember->fresh()->toAdminArray(),
        ]);
    }

    public function destroy(TeamMember $teamMember): JsonResponse
    {
        $this->deleteStoredImage($teamMember->image);
        $teamMember->delete();

        return response()->json([
            'message' => 'Team member deleted.',
        ]);
    }

    private function validated(Request $request, ?TeamMember $member = null): array
    {
        $focus = $request->input('focus');
        if (is_string($focus)) {
            $focus = collect(preg_split('/[\n,]+/', $focus) ?: [])
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();
            $request->merge(['focus' => $focus]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['required', 'string', 'max:160'],
            'slug' => [
                'nullable',
                'string',
                'max:120',
                'alpha_dash',
                Rule::unique('team_members', 'slug')->ignore($member?->id),
            ],
            'short_bio' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string'],
            'focus' => ['nullable', 'array'],
            'focus.*' => ['string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['sometimes', 'boolean'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? ($member?->sort_order ?? 0));
        $data['is_active'] = $request->has('is_active')
            ? $request->boolean('is_active')
            : ($member?->is_active ?? true);
        $data['focus'] = $data['focus'] ?? [];

        unset($data['image_path'], $data['image']);

        return $data;
    }

    private function resolveImage(Request $request, ?string $current): ?string
    {
        if ($request->hasFile('image')) {
            $this->deleteStoredImage($current);
            $path = $request->file('image')->store('team', 'public');

            return '/storage/'.$path;
        }

        $imagePath = trim((string) $request->input('image_path', ''));
        if ($imagePath !== '') {
            return $imagePath;
        }

        return $current;
    }

    private function deleteStoredImage(?string $image): void
    {
        if (! $image || ! str_starts_with($image, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(ltrim(substr($image, strlen('/storage/')), '/'));
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'member';
        $slug = $base;
        $i = 2;

        while (
            TeamMember::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
