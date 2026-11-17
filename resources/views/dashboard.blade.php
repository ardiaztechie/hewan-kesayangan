<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Akun Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">Halo, {{ auth()->user()->name }}!</h3>
                    <p>Selamat datang di toko resmi Hewan Kesayangan.</p>
                    <div class="card-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="card bg-base-100 shadow-sm"><div class="card-body">
                    <h4 class="font-semibold">Pesanan Saya</h4>
                    <p class="text-sm opacity-70">Belum Bayar, Dikemas, Dikirim, Selesai.</p>
                    <span class="badge badge-ghost">Segera hadir</span>
                </div></div>
                <div class="card bg-base-100 shadow-sm"><div class="card-body">
                    <h4 class="font-semibold">Alamat Saya</h4>
                    <p class="text-sm opacity-70">Alamat pengiriman untuk checkout.</p>
                    <span class="badge badge-ghost">Segera hadir</span>
                </div></div>
                <a href="{{ route('profile.edit') }}" class="card bg-base-100 shadow-sm transition hover:shadow-md"><div class="card-body">
                    <h4 class="font-semibold">Profil</h4>
                    <p class="text-sm opacity-70">Ubah nama, email, dan password.</p>
                </div></a>
            </div>
        </div>
    </div>
</x-app-layout>
