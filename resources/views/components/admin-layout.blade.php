@props(['title' => 'Seller Centre'])
@php($user = auth()->user())
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Seller Centre Hewan Kesayangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 font-sans antialiased">
<div class="drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle">

    <div class="drawer-content flex flex-col">
        {{-- Bar atas --}}
        <div class="navbar sticky top-0 z-30 border-b border-base-300 bg-base-100 px-4">
            <label for="admin-drawer" class="btn btn-square btn-ghost lg:hidden" aria-label="Buka menu">&#9776;</label>
            <h1 class="flex-1 text-lg font-semibold">{{ $title }}</h1>
            <div class="flex items-center gap-3">
                <span class="badge {{ $user->isOwner() ? 'badge-primary' : 'badge-secondary' }}">{{ $user->role->label() }}</span>
                <span class="hidden text-sm sm:inline">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
                </form>
            </div>
        </div>

        <main class="p-4 lg:p-6">
            @if (session('status'))
                <div role="alert" class="alert alert-success mb-4">{{ session('status') }}</div>
            @endif
            {{ $slot }}
        </main>
    </div>

    {{-- Sidebar --}}
    <div class="drawer-side z-40">
        <label for="admin-drawer" class="drawer-overlay" aria-label="Tutup menu"></label>
        <aside class="min-h-full w-64 border-r border-base-300 bg-base-100">
            <div class="border-b border-base-300 p-4">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">Hewan Kesayangan</a>
                <p class="text-xs opacity-60">Seller Centre</p>
            </div>
            <ul class="menu gap-1 p-2">
                <li><a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a></li>

                <li class="menu-title">Operasional</li>
                <li class="disabled"><span>Pesanan <span class="badge badge-ghost badge-sm">Tahap 6</span></span></li>
                <li class="disabled"><span>Produk &amp; Stok <span class="badge badge-ghost badge-sm">Tahap 3</span></span></li>

                @if ($user->isOwner())
                    <li class="menu-title">Manajemen Toko</li>
                    <li class="disabled"><span>Promosi <span class="badge badge-ghost badge-sm">Tahap 4</span></span></li>
                    <li class="disabled"><span>Pengembalian &amp; Refund <span class="badge badge-ghost badge-sm">Tahap 7</span></span></li>
                    <li class="disabled"><span>Keuangan &amp; Laporan <span class="badge badge-ghost badge-sm">Tahap 8</span></span></li>
                    <li class="disabled"><span>Pengaturan Toko <span class="badge badge-ghost badge-sm">Tahap 8</span></span></li>
                    <li><a href="{{ route('admin.staff.index') }}" @class(['active' => request()->routeIs('admin.staff.*')])>Akun Staf</a></li>
                @endif

                <li class="menu-title">Lainnya</li>
                <li><a href="{{ route('home') }}">Lihat Toko</a></li>
                <li><a href="{{ route('profile.edit') }}">Profil Saya</a></li>
            </ul>
        </aside>
    </div>
</div>
</body>
</html>
