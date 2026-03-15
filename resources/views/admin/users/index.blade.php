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
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline toggle-form">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-bold text-indigo-500 hover:underline">Toggle Role</button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline ban-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-500 hover:underline">Ban</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#usersTable').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: 'none',
                    target: ''
                }
            },
            pageLength: 25,
            language: { search: "", searchPlaceholder: "Find a user..." }
        });

        // Common Swal Styling Classes to match your theme
        const swalCustomClasses = {
            popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[3rem] shadow-2xl p-6',
            title: 'text-[#4A3728] dark:text-white font-black text-2xl mt-2',
            htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-2 text-sm font-medium leading-relaxed',
            confirmButton: 'flex items-center justify-center bg-orange-400 hover:bg-orange-500 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4',
            cancelButton: 'flex items-center justify-center bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-white/20 px-6 py-3 rounded-full transition-all font-bold border-none mx-2 mt-4'
        };

        // Handle Role Toggle Confirmation
        $('.toggle-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Change Permissions?',
                text: "Are you sure you want to toggle this user's admin rights?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update role!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: swalCustomClasses
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Handle Ban User Confirmation
        $('.ban-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Ban User?',
                text: "This action cannot be undone. They will lose access permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ban them!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    ...swalCustomClasses,
                    confirmButton: 'flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4' // Override with danger color
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Handle Backend Session Messages (Errors & Successes)
        @if(session('error') || session('success'))
            Swal.fire({
                icon: '{{ session('error') ? 'error' : 'success' }}',
                title: '{{ session('error') ? 'Oops!' : 'Success!' }}',
                text: '{{ session('error') ?? session('success') }}',
                buttonsStyling: false,
                customClass: swalCustomClasses
            });
        @endif
    });
</script>
@endpush
@endsection
