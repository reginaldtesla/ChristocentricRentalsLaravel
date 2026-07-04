<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::query()->orderBy('name')->paginate(30),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === $request->user()->id && ! $request->boolean('is_admin')) {
            return back()->with('error', 'You cannot remove your own admin access.');
        }

        $validated = $request->validate([
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return back()->with('success', 'User updated.');
    }
}
