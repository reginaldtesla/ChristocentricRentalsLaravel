<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminAccount
{
    public static function ensureExists(): void
    {
        $email = self::email();

        if ($email === '' || self::password() === '') {
            return;
        }

        if (User::query()->where('email', $email)->exists()) {
            return;
        }

        self::sync();
    }

    public static function sync(?string $previousEmail = null, ?array $overrides = null): User
    {
        $email = strtolower(trim((string) ($overrides['email'] ?? self::email())));
        $password = (string) ($overrides['password'] ?? self::password());
        $name = trim((string) ($overrides['name'] ?? self::name())) ?: 'Admin';

        if ($email === '' || $password === '') {
            throw new RuntimeException('Admin email and password must be set in .env.');
        }

        $previousEmail ??= $email;

        if ($previousEmail !== $email) {
            User::query()
                ->where('email', $previousEmail)
                ->where('is_admin', true)
                ->update(['is_admin' => false]);
        }

        /** @var User $user */
        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );

        if (! $user->is_admin) {
            $user->update(['is_admin' => true]);
        }

        return $user->fresh();
    }

    public static function name(): string
    {
        return trim((string) config('admin.name', 'Admin')) ?: 'Admin';
    }

    public static function email(): string
    {
        return strtolower(trim((string) config('admin.email', '')));
    }

    public static function password(): string
    {
        return (string) config('admin.password', '');
    }
}
