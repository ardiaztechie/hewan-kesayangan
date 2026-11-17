<x-admin-layout title="Tambah Staf">
    <div class="card max-w-xl bg-base-100 shadow-sm">
        <form method="POST" action="{{ route('admin.staff.store') }}" class="card-body space-y-3">
            @csrf
            @foreach ([
                ['name', 'Nama lengkap', 'text', true],
                ['email', 'Email (untuk login)', 'email', true],
                ['phone', 'No. HP / WhatsApp', 'text', false],
            ] as [$field, $label, $type, $required])
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ $label }}</span></div>
                    <input type="{{ $type }}" name="{{ $field }}" value="{{ old($field) }}" @required($required)
                           @class(['input input-bordered w-full', 'input-error' => $errors->has($field)])>
                    @error($field)<div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>@enderror
                </label>
            @endforeach

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Password (min. 8 karakter)</span></div>
                <input type="password" name="password" required
                       @class(['input input-bordered w-full', 'input-error' => $errors->has('password')])>
                @error('password')<div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>@enderror
            </label>
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ulangi password</span></div>
                <input type="password" name="password_confirmation" required class="input input-bordered w-full">
            </label>

            <div class="card-actions justify-end pt-2">
                <a href="{{ route('admin.staff.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Staf</button>
            </div>
        </form>
    </div>
</x-admin-layout>
