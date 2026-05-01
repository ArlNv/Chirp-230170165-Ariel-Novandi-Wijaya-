<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirper - Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            transition: background-image 0.5s ease-in-out;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }

        [data-theme="lofi"] body {
            background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)),
                url('https://images.unsplash.com/photo-1510070112810-d4e9a46d9e91?q=80&w=2069&auto=format&fit=crop');
        }

        [data-theme="black"] body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop');
        }

        .card {
            backdrop-filter: blur(8px);
            background-color: rgba(var(--b1), 0.8) !important;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans">
    <nav class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost text-xl">🐦 Chirper</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow border border-primary">
                    @auth
                        <li class="menu-title text-primary italic">Welcome, {{ Auth::user()->name }}</li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="text-error font-bold w-full text-left px-4 py-2 hover:bg-error/10">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('home') }}" class="font-bold">Sign In</a></li>
                        <li><a onclick="my_modal.showModal()">System Info</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="navbar-end gap-2">
            <button id="btn-sign-in" class="btn btn-ghost btn-sm text-primary">Bright</button>
            <button id="btn-sign-up" class="btn btn-neutral btn-sm">Dark</button>
        </div>
    </nav>

    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">

            @if(session('success'))
                <div role="alert" class="alert alert-success shadow-lg mb-6 rounded-none border-l-4 border-success animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div role="alert" class="alert alert-error shadow-lg mb-6 rounded-none border-l-4 border-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="card bg-base-100 shadow mt-4">
                <div class="card-body">
                    <h1 class="text-3xl font-bold">Welcome to Chirper 🐦!</h1>
                    <p class="mt-2 text-base-content/60">Bagikan apa yang ada di pikiranmu sekarang!</p>

                    @auth
                        <!-- Form Input Chirp -->
                        <form method="POST" action="{{ route('chirps.store') }}" class="mt-6">
                            @csrf 
                            <textarea
                                name="message"
                                maxlength="255"
                                placeholder="Apa yang terjadi hari ini?"
                                class="textarea textarea-bordered w-full resize-none focus:outline-primary text-base @error('message') textarea-error @enderror"
                                rows="3">{{ old('message') }}</textarea>

                            <div class="flex justify-between items-center mt-1">
                                <div>
                                    @error('message')
                                        <p class="text-error text-xs font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <span class="text-[10px] opacity-40 font-mono" id="char-count">0/255</span>
                            </div>

                            <div class="card-actions justify-end mt-4">
                                <button type="submit" class="btn btn-primary px-8">Kirim Chirp</button>
                            </div>
                        </form>
                    @else

                        <div class="bg-base-200 p-8 mt-6 rounded-lg border-2 border-dashed border-primary/30">
                            <div class="text-center mb-6">
                                <span class="text-5xl">🔑</span>
                                <h2 class="text-xl font-bold mt-2">Silahkan Login</h2>
                                <p class="text-sm opacity-60">Silakan login untuk mulai mengirim pesan</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                                @csrf 
                                <div class="form-control">
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" class="input input-bordered w-full focus:input-primary" required>
                                </div>
                                <div class="form-control">
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Alamat Email" class="input input-bordered w-full focus:input-primary" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-full shadow-lg font-bold">Masuk Sekarang</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="mt-12 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-xl font-black uppercase tracking-tight">Timeline</h2>
                    <span class="badge badge-primary badge-outline font-bold">{{ count($chirps) }} Pesan</span>
                </div>

                @forelse ($chirps as $chirp)
                    <div class="card bg-base-100 shadow-sm border border-base-300 hover:border-primary/50 transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body p-5">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-10">
                                            <span class="text-sm font-bold">{{ strtoupper(substr($chirp->user->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="font-bold text-primary block leading-none hover:underline cursor-pointer">{{ $chirp->user->name }}</span>
                                        <span class="text-[10px] text-base-content/40 uppercase font-black">{{ $chirp->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4 text-base-content leading-relaxed">{{ $chirp->message }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 card bg-base-200/30 border-2 border-dashed border-base-300">
                        <p class="text-base-content/40 italic">Belum ada kicauan. Jadilah yang pertama!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="footer footer-center p-8 bg-base-300/50 text-base-content text-xs mt-20">
        <div>
            <div class="font-black text-lg mb-2 text-primary opacity-50">CHIRPER</div>
            <p>© 2026 - Designed by Laravel </p>
            <p class="font-medium opacity-70">Ariel Novandi Wijaya, 230170165</p>
        </div>
    </footer>

    <!-- Modal Alert -->
    <dialog id="my_modal" class="modal">
        <div class="modal-box rounded-none border-4 border-primary p-10 flex flex-col items-center justify-center text-center">
            <span class="text-7xl mb-4">📢</span>
            <h3 class="text-2xl font-black uppercase tracking-widest text-primary">Informasi Sistem</h3>
            <p class="py-4 text-lg font-medium leading-relaxed">
                Aplikasi ini menggunakan <b>Session Storage</b>. <br>
                Pesan yang Anda kirim akan muncul di timeline secara instan tanpa database, 
                namun akan terhapus otomatis saat Anda melakukan Logout.
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary rounded-none px-12 font-bold">MENGERTI</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/60 backdrop-blur-sm">
            <button>close</button>
        </form>
    </dialog>

    <script>
        const htmlElement = document.documentElement;
        const signInBtn = document.getElementById('btn-sign-in');
        const signUpBtn = document.getElementById('btn-sign-up');
        const textarea = document.querySelector('textarea[name="message"]');
        const charCount = document.getElementById('char-count');

        if (signInBtn) {
            signInBtn.addEventListener('click', () => htmlElement.setAttribute('data-theme', 'lofi'));
        }
        if (signUpBtn) {
            signUpBtn.addEventListener('click', () => htmlElement.setAttribute('data-theme', 'black'));
        }

        if (textarea) {
            textarea.addEventListener('input', () => {
                charCount.textContent = `${textarea.value.length}/255`;
                if(textarea.value.length >= 240) charCount.classList.add('text-error');
                else charCount.classList.remove('text-error');
            });
        }
    </script>
</body>
</html>
