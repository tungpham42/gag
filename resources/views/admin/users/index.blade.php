@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Community Members</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600">
            &larr; Back to Hub
        </a>
    </div>
    <div class="bg-white dark:bg-[#1C1926] rounded-[2.5rem] p-8 border border-orange-50 dark:border-white/5 shadow-xl">

        <table id="usersTable" class="w-full">
            <thead>
                <tr class="text-left text-[#8C7A6B] uppercase text-xs tracking-widest">
                    <th class="pb-4">User</th>
                    <th class="pb-4">Role</th>
                    <th class="pb-4">Joined</th>
                    <th class="pb-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                @foreach($users as $user)
                <tr>
                    <td class="py-4 flex items-center gap-3">
                        <img src="{{ $user->avatar }}" class="w-10 h-10 rounded-2xl">
                        <div>
                            <div class="font-bold">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="{{ $user->is_admin ? 'text-orange-500' : 'text-gray-400' }} font-bold text-xs uppercase">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td class="py-4 text-sm">{{ $user->created_at->format('M Y') }}</td>
                    <td class="py-4 text-right space-x-2">
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button class="text-xs font-bold text-indigo-500 hover:underline">Toggle Role</button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-xs font-bold text-rose-500 hover:underline" onclick="return confirm('Delete user?')">Ban</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 25,
            language: { search: "", searchPlaceholder: "Find a user..." }
        });
    });
</script>
@endsection
