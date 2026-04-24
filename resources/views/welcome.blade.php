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

        /* Background untuk Mode Terang (Sign In) */
        [data-theme="lofi"] body {
            background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)),
                url('https://images.unsplash.com/photo-1510070112810-d4e9a46d9e91?q=80&w=2069&auto=format&fit=crop');
        }

        /* Background untuk Mode Gelap (Sign Up) */
        [data-theme="black"] body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop');
        }

        /* Membuat card sedikit transparan agar background terlihat */
        .card {
            backdrop-filter: blur(8px);
            background-color: rgba(var(--b1), 0.8) !important;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-base-200 font-sans">
    <nav class="navbar bg-base-100">
        <div class="navbar-start">
            <button onclick="my_modal.showModal()" class="btn btn-ghost text-xl">🐦 Chirper</button>
        </div>
        <div class="navbar-end gap-2">
            <a href="#" id="btn-sign-in" class="btn btn-ghost btn-sm">Sign In</a>

            <a href="#" id="btn-sign-up" class="btn btn-neutral btn-sm">Sign Up</a>
        </div>
    </nav>

    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="card bg-base-100 shadow mt-8">
                <div class="card-body">
                    <h1 class="text-3xl font-bold">Welcome to Chirper 🐦!</h1>
                    <p class="mt-2 text-base-content/60">Saatnya Untuk Kicauuu (or chirp)!</p>

                    <form method="POST" action="{{ route('chirps.store') }}" class="mt-6">
                        @csrf
                        <textarea
                            name="message"
                            placeholder="What's on your mind?"
                            class="textarea textarea-bordered w-full resize-none focus:outline-primary text-base"
                            rows="3">{{ old('message') }}</textarea>

                        @if($errors->has('message'))
                        <p class="text-error text-sm mt-2">{{ $errors->first('message') }}</p>
                        @endif

                        <div class="card-actions justify-end mt-4">
                            <button type="submit" class="btn btn-primary">Chirp</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-10 space-y-4">
                <h2 class="text-xl font-semibold px-2">Recent Chirps</h2>

                @forelse ($chirps as $chirp)
                <div class="card bg-base-100 shadow-sm border border-base-300">
                    <div class="card-body p-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-primary">{{ $chirp['name'] }}</span>
                                <span class="text-xs text-base-content/50">· {{ $chirp['time'] }}</span>
                            </div>
                        </div>
                        <p class="mt-2 text-base-content">{{ $chirp['message'] }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-base-content/50">Belum ada chirp. Ayo tulis sesuatu!</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
        <div>
            <p>© 2026 Chirper - Built with Laravel, Ariel Novandi Wijaya (230170165)</p>
        </div>
    </footer>
    <dialog id="my_modal" class="modal">
        <div class="modal-box rounded-none border-4 border-primary p-10 flex flex-col items-center justify-center text-center">
            <span class="text-6xl mb-4">🚨</span>
            <h3 class="text-2xl font-black uppercase tracking-widest text-primary">System Alert</h3>
            <p class="py-4 text-lg font-medium">
                Halo Sobat! <br>
                Tombol ini sedang tidak dapat di akses!!📢 <br>
                Maaf atas ketidaknyamanannya!
            </p>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary rounded-none px-8">OKE!</button>
                </form>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <script>
    // Deklarasikan variabel cukup SATU kali saja
    const htmlElement = document.documentElement;
    const signInBtn = document.getElementById('btn-sign-in');
    const signUpBtn = document.getElementById('btn-sign-up');
    const btnShowImage = document.getElementById('btn-show-image');

    if (signInBtn) {
        signInBtn.addEventListener('click', function(e) {
            e.preventDefault();
            htmlElement.setAttribute('data-theme', 'lofi');
        });
    }

    if (signUpBtn) {
        signUpBtn.addEventListener('click', function(e) {
            e.preventDefault();
            htmlElement.setAttribute('data-theme', 'black');
        });
    }

    if (btnShowImage) {
        btnShowImage.addEventListener('click', function(e) {
            e.preventDefault();
            // Jika kamu pakai modal DaisyUI, panggil fungsinya di sini
            if (window.my_modal) {
                my_modal.showModal();
            }
        });
    }
</script>
</body>

</html>