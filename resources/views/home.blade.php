@use('App\Support\Format')
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting?->store_name ?? 'Hewan Kesayangan Anda' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 font-sans antialiased">
    <div class="navbar border-b border-base-300 bg-base-100 px-4">
        <a href="{{ route('home') }}" class="flex-1 text-lg font-bold">{{ $setting?->store_name ?? 'Hewan Kesayangan Anda' }}</a>
        <div class="flex gap-2">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Seller Centre</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Akun Saya</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @endauth
        </div>
    </div>

    @if ($setting?->is_holiday_mode)
        <div role="alert" class="alert alert-warning rounded-none">
            {{ $setting->holiday_message ?: 'Toko sedang libur' }}
            @if ($setting->holiday_until) sampai {{ $setting->holiday_until->translatedFormat('d F Y') }} @endif.
            Pesanan baru belum bisa dibuat.
        </div>
    @endif

    <section class="bg-base-100">
        <div class="mx-auto max-w-6xl px-4 py-10">
            <h1 class="text-3xl font-bold">Perlengkapan Ternak &amp; Hewan Kesayangan</h1>
            <p class="mt-2 max-w-2xl opacity-70">{{ $setting?->description }}</p>
            <p class="mt-1 text-sm opacity-70">Beli banyak lebih hemat dengan harga grosir otomatis.</p>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-4 py-8">
        <h2 class="mb-4 text-xl font-semibold">Produk</h2>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            @forelse ($products as $product)
                @php
                    $minPrice = $product->variants->min(fn ($v) => (float) ($v->activeDiscountPrice() ?? $v->price));
                    $minWholesale = $product->variants->flatMap->wholesalePrices->min('price');
                    $stock = $product->variants->sum(fn ($v) => $v->availableStock());
                    $image = $product->images->first();
                @endphp
                <div class="card bg-base-100 shadow-sm">
                    <figure class="aspect-square bg-base-300">
                        @if ($image)
                            <img src="{{ asset('storage/'.$image->path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-sm opacity-50">Foto belum ada</span>
                        @endif
                    </figure>
                    <div class="card-body gap-1 p-4">
                        <h3 class="font-medium leading-snug">{{ $product->name }}</h3>
                        <p class="text-lg font-bold text-primary">{{ Format::rupiah($minPrice) }}</p>
                        <div class="flex flex-wrap gap-1">
                            @if ($minWholesale)
                                <span class="badge badge-secondary badge-sm">Grosir mulai {{ Format::rupiah($minWholesale) }}</span>
                            @endif
                            @if ($stock <= 0)
                                <span class="badge badge-error badge-sm">Stok Habis</span>
                            @endif
                        </div>
                        <p class="text-xs opacity-60">Terjual {{ $product->sold_count }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full opacity-60">Belum ada produk.</p>
            @endforelse
        </div>
        <p class="mt-6 text-xs opacity-60">Halaman detail produk, keranjang, dan checkout dibuat di Tahap 3 dan 4.</p>
    </main>
</body>
</html>
