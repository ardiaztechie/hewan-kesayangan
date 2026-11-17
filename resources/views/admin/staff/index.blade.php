<x-admin-layout title="Akun Staf">
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm opacity-70">Staf hanya bisa memproses pesanan dan mengelola stok.</p>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm">+ Tambah Staf</a>
    </div>

    @if ($errors->any())
        <div role="alert" class="alert alert-error mb-4">{{ $errors->first() }}</div>
    @endif

    <div class="card bg-base-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Status</th><th class="text-right">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($staff as $member)
                        <tr>
                            <td class="font-medium">{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $member->is_active ? 'badge-success' : 'badge-ghost' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.staff.toggle', $member) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-outline btn-xs">
                                            {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <details class="dropdown dropdown-end">
                                        <summary class="btn btn-ghost btn-xs">Reset Password</summary>
                                        <form method="POST" action="{{ route('admin.staff.password', $member) }}"
                                              class="dropdown-content z-10 mt-2 w-64 space-y-2 rounded-box bg-base-100 p-3 shadow">
                                            @csrf @method('PATCH')
                                            <input type="password" name="password" required minlength="8"
                                                   placeholder="Password baru (min. 8 karakter)" class="input input-bordered input-sm w-full">
                                            <button type="submit" class="btn btn-primary btn-sm w-full">Simpan</button>
                                        </form>
                                    </details>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center opacity-60">Belum ada akun staf.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
