@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <p class="text-sm text-gray-600">Grant admin access to trusted staff. Admins can manage products, orders, newsletters, and site content.</p>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Admin</th>
                    <th class="px-4 py-3">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_admin" value="0">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="is_admin" value="1" @checked($user->is_admin) onchange="this.form.submit()">
                                    <span class="text-xs text-gray-600">Admin</span>
                                </label>
                            </form>
                        </td>
                        <td class="px-4 py-3">{{ $user->created_at?->format('M j, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
