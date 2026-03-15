@extends('layouts.app')

@section('content')
<div class="space-y-6 px-4 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#4A3728] dark:text-white">Community Members</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 inline-flex items-center">
            &larr; Back to Hub
        </a>
    </div>

    <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] sm:rounded-[2.5rem] p-4 sm:p-8 border border-orange-50 dark:border-white/5 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table id="usersTable" class="w-full display nowrap">
                <thead>
                    <tr class="text-left text-[#8C7A6B] uppercase text-[10px] sm:text-xs tracking-widest">
                        <th class="pb-4">User</th>
                        <th class="pb-4">Role</th>
                        <th class="pb-4">Joined</th>
                        <th class="pb-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                    @foreach($users as $user)
                    <tr class="group">
                        <td class="py-4 flex items-center gap-3">
                            <img src="{{ $user->avatar }}" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl object-cover">
                            <div class="min-w-0">
                                <div class="font-bold text-sm sm:text-base truncate">{{ $user->name }}</div>
                                <div class="text-[10px] sm:text-xs text-gray-400 truncate">{{ $user->email }}</div>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="inline-block px-2 py-1 rounded-lg {{ $user->is_admin ? 'bg-orange-50 text-orange-500 dark:bg-orange-500/10' : 'bg-gray-50 text-gray-400 dark:bg-white/5' }} font-bold text-[10px] uppercase">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="py-4 text-xs sm:text-sm text-[#8C7A6B] dark:text-gray-400">
                            {{ $user->created_at->format('M Y') }}
                        </td>
                        <td class="py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline toggle-form">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-[10px] sm:text-xs font-bold text-indigo-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">Role</button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline ban-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] sm:text-xs font-bold text-rose-500 hover:text-rose-600 transition-colors uppercase tracking-wider">Ban</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable with Responsive plugin
        $('#usersTable').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: 'none',
                    target: ''
                }
            },
            pageLength: 25,
            autoWidth: false,
            dom: '<"flex flex-col sm:flex-row justify-between gap-4 mb-4"f>rt<"flex flex-col sm:flex-row justify-between items-center gap-4 mt-4"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search users...",
                paginate: {
                    previous: "←",
                    next: "→"
                }
            }
        });

        // Styling for DataTable Search and Pagination (Tailwind adjustments)
        $('.dataTables_filter input').addClass('bg-orange-50 dark:bg-white/5 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-orange-200 outline-none w-full sm:w-64');
        $('.dataTables_info').addClass('text-xs text-[#8C7A6B] font-medium');

        const swalCustomClasses = {
            popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[2.5rem] shadow-2xl p-4 sm:p-6',
            title: 'text-[#4A3728] dark:text-white font-black text-xl sm:text-2xl mt-2',
            htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-2 text-xs sm:text-sm font-medium leading-relaxed',
            confirmButton: 'bg-orange-400 hover:bg-orange-500 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4',
            cancelButton: 'bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-white/20 px-6 py-3 rounded-full transition-all font-bold border-none mx-2 mt-4'
        };

        $('.toggle-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Change Permissions?',
                text: "Toggle this user's admin rights?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: swalCustomClasses
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });

        $('.ban-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Ban User?',
                text: "They will lose access permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ban!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    ...swalCustomClasses,
                    confirmButton: 'bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4'
                }
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });

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

<style>
    /* Custom DataTable Pagination Styling */
    .dataTables_paginate .paginate_button {
        @apply px-3 py-1 mx-1 rounded-lg bg-orange-50 dark:bg-white/5 text-[#4A3728] dark:text-white font-bold cursor-pointer transition-all;
    }
    .dataTables_paginate .paginate_button.current {
        @apply bg-orange-400 text-white shadow-md;
    }
    .dataTables_paginate .paginate_button:hover:not(.current) {
        @apply bg-orange-100 dark:bg-white/10;
    }
</style>
@endpush
@endsection
