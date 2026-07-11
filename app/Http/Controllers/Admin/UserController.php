<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $users->setCollection(
            $users->getCollection()->map(fn (User $user) => $user->only(['id', 'name', 'email', 'created_at', 'updated_at']))
        );

        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'User created.',
            'data' => $user->only(['id', 'name', 'email', 'created_at', 'updated_at']),
        ], 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:190',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated.',
            'data' => $user->only(['id', 'name', 'email', 'created_at', 'updated_at']),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if ($request->user()?->id === $user->id) {
            return response()->json([
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        if (User::query()->count() <= 1) {
            return response()->json([
                'message' => 'At least one admin user must remain.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted.',
        ]);
    }
}
