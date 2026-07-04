<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function orders(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->with('items')
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function showOrder(Request $request, string $orderNumber)
    {
        $order = $request->user()
            ->orders()
            ->where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('account.order-show', compact('order'));
    }

    public function edit(Request $request)
    {
        return view('account.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated.');
    }
}
