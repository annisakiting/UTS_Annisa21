<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Selamat Datang di Aplikasi Penjahit</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
            
            <!-- Navigasi (Login/Register) -->
            <header class="absolute inset-x-0 top-0 z-50">
                <nav class="flex items-center justify-end p-6 lg:px-8" aria-label="Global">
                    @if (Route::has('login'))
                        <div class="text-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Log in <span aria-hidden="true">&rarr;</span></a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm font-semibold leading-6 text-gray-900 dark:text-white">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </header>

            <!-- Konten Utama (Hero Section) -->
            <main class="relative isolate px-6 pt-14 lg:px-8">
                <div class="mx-auto max-w-3xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                            Aplikasi Penjahit Digital
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            Solusi modern untuk mengelola setiap pesanan, data pelanggan, dan catatan ukuran jahitan Anda di satu tempat yang terorganisir.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Masuk ke Dashboard Admin
                            </a>
                            <a href="#fitur" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                                Lihat Fitur <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bagian Fitur -->
                <div class="py-24 sm:py-32" id="fitur">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl lg:text-center">
                            <h2 class="text-base font-semibold leading-7 text-indigo-600">Semua Terorganisir</h2>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                                Semua yang Anda Butuhkan untuk Manajemen Penjahit
                            </p>
                        </div>
                        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                                
                                <!-- Fitur 1: Manajemen Pelanggan -->
                                <div class="relative pl-16">
                                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 005.654-4.041m0 0l-.92-1.381a.563.563 0 00-.73-.2l-2.007.669a.5.5 0 01-.644-.225l-1.382-2.302a.563.563 0 00-.61-.308L10 5.418M10 5.418a.563.563 0 00-.61.308L8.008 8.029a.5.5 0 01-.644.225l-2.007-.669a.563.563 0 00-.73.2l-.92 1.381c-1.63.247-3.085 1.189-4.041 2.569m0 0a9.38 9.38 0 000 5.138m0 0a9.38 9.38 0 004.04 2.569m0 0l.92 1.381a.563.563 0 00.73.2l2.007-.669a.5.5 0 01.644.225l1.382 2.302a.563.563 0 00.61.308L14 18.582m0 0a.563.563 0 00.61-.308l1.382-2.302a.5.5 0 01.644-.225l2.007.669a.563.563 0 00.73-.2l.92-1.381m-5.654-4.041A9.38 9.38 0 0010 5.418m0 0a9.38 9.38 0 00-4.04 2.569M14 18.582l-4-6.87a.5.5 0 00-.866 0l-4 6.87m10.154-1.346a.5.5 0 00-.866 0L10 11.713M10 11.713l-1.13 1.956a.5.5 0 00.866.5l1.13-1.956a.5.5 0 00-.866-.5z" />
                                            </svg>
                                        </div>
                                        Manajemen Pelanggan & Ukuran
                                    </dt>
                                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Simpan data pelanggan, nomor kontak, dan semua catatan ukuran (kemeja, celana, dll) secara detail dengan sistem JSON yang fleksibel.
                                    </dd>
                                </div>
                                
                                <!-- Fitur 2: Lacak Pesanan -->
                                <div class="relative pl-16">
                                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                                            </svg>
                                        </div>
                                        Pelacakan Status Pesanan
                                    </dt>
                                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Catat pesanan baru dan lacak progresnya, mulai dari 'Pending', 'Cutting' (Potong), 'Sewing' (Jahit), hingga 'Completed' (Selesai).
                                    </dd>
                                </div>
                                
                                <!-- Fitur 3: Manajemen Keuangan -->
                                <div class="relative pl-16">
                                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.097V3.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.75C2.25 5.017 2.017 4.784 1.732 4.602a1.732 1.732 0 00-1.64 0A1.732 1.732 0 00.25 5.25v.75m0 0H1.5A.75.75 0 00.75 7.5v.006a.75.75 0 00.75.75H1.5m0 0v.75a.75.75 0 00.75.75h.75m0 0v.75a.75.75 0 00.75.75h.75m0 0v.75a.75.75 0 00.75.75h.75m0 0v.75a.75.75 0 00.75.75H9.75m0 0v-.75a.75.75 0 00-.75-.75H9m0 0v-.75a.75.75 0 00-.75-.75H7.5m0 0v-.75a.75.75 0 00-.75-.75H6m0 0v-.75a.75.75 0 00-.75-.75H4.5M3 6h-.75m0 0v-.75c0-.983.8-1.75 1.75-1.75H6m0 0v.75M3.75 6h.75m0 0v.75m0 0v.75m0 0h1.5m0 0h.75m0 0h.75m0 0h.75m0 0h.75M9.75 12h.75m0 0h.75m0 0h.75M12 12h.75m0 0h.75m0 0h.75M14.25 12h.75m0 0h.75m0 0h.75M16.5 12h.75m0 0h.75M18.75 12h.75m0 0h.75m0 0h.75M21 12v.75m0 0v.75m0 0v.75m0 0v.75m0 0v.75m0 0V3.75c0-.755-.696-1.097-1.453-1.097A60.07 60.07 0 003.75 4.5v.75m16.5 0v.75" />
                                            </svg>
                                        </div>
                                        Nota & Keuangan
                                    </dt>
                                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Buat pesanan dinamis, catat Uang Muka (DP), hitung total tagihan, dan cetak Nota (halaman detail pesanan) untuk pelanggan.
                                    </d>
                                </div>
                                
                                <!-- Fitur 4: Database Layanan -->
                                <div class="relative pl-16">
                                    <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                        <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.61 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.61-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.61-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.61 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                            </svg>
                                        </div>
                                        Database Layanan
                                    </dt>
                                    <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Kelola daftar layanan jahitan yang Anda tawarkan (Kemeja, Celana, dll) beserta harga dasarnya.
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-32 pb-8">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="border-t border-gray-900/10 dark:border-gray-100/10 pt-8">
                            <p class="text-center text-xs leading-5 text-gray-500">&copy; 2025 Aplikasi Penjahit. Dibuat dengan Laravel & Tailwind CSS.</p>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </body>
</html>