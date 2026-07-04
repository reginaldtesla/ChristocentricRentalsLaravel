<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminAccount;
use App\Support\EnvWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminAccountController extends Controller
{
    public function edit()
    {
        return view('admin.settings.account', [
            'name' => AdminAccount::name(),
            'email' => AdminAccount::email(),
        ]);
    }

    public function update(Request $request)
    {
        $previousEmail = AdminAccount::email();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'password_confirmation' => ['nullable', 'same:password'],
        ]);

        $envValues = [
            'ADMIN_NAME' => $validated['name'],
            'ADMIN_EMAIL' => strtolower($validated['email']),
        ];

        if (filled($validated['password'] ?? null)) {
            $envValues['ADMIN_PASSWORD'] = $validated['password'];
        }

        EnvWriter::set($envValues);

        Artisan::call('config:clear');

        $syncOverrides = [
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
        ];

        if (filled($validated['password'] ?? null)) {
            $syncOverrides['password'] = $validated['password'];
        }

        AdminAccount::sync($previousEmail, $syncOverrides);

        return back()->with('success', 'Admin login updated. Use your new credentials next time you sign in.');
    }
}
