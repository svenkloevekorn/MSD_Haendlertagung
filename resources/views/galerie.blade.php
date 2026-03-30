<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery – International Sales Meeting 2026 | Mühlen Sohn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { brand: { green: '#0EA039', dark: '#565656' } } } } }
    </script>
</head>
<body class="font-sans text-gray-800 antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('startseite') }}" class="flex items-center gap-3"><img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-10"></a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="{{ route('startseite') }}" class="hover:text-gray-900 transition">Home</a>
                <a href="{{ route('agenda') }}" class="hover:text-gray-900 transition">Agenda</a>
                <a href="{{ route('formular') }}" class="hover:text-gray-900 transition">Registration</a>
                <a href="{{ route('galerie') }}" class="text-gray-900">Gallery</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
                <a href="{{ route('feedback') }}" class="hover:text-gray-900 transition">Feedback</a>
                <a href="{{ route('kontakt') }}" class="hover:text-gray-900 transition">Contact</a>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Log out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
            <button id="menu-toggle" class="md:hidden p-2 text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-6 py-4 flex flex-col gap-3 text-sm font-medium text-gray-600">
                <a href="{{ route('startseite') }}">Home</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}">Registration</a><a href="{{ route('galerie') }}" class="text-gray-900">Gallery</a><a href="{{ route('downloads') }}">Downloads</a><a href="{{ route('feedback') }}">Feedback</a><a href="{{ route('kontakt') }}">Contact</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600">Log out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Impressions</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Gallery</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Photos from our International Sales Meeting 2026 – will be published after the event.</p>
        </div>
    </section>

    <!-- Galerie Grid -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            @if($images->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $image)
                        <div class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100 cursor-pointer" onclick="openLightbox({{ $loop->index }})">
                            <img src="{{ route('galerie.image', $image) }}" alt="{{ $image->title ?? 'Gallery Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                            @if($image->title)
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                                    <p class="text-white text-sm font-medium">{{ $image->title }}</p>
                                    @if($image->description)
                                        <p class="text-white/70 text-xs mt-0.5">{{ $image->description }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox -->
                <div id="lightbox" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center" onclick="closeLightbox(event)">
                    <button onclick="closeLightbox(event)" class="absolute top-6 right-6 text-white/70 hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <button onclick="prevImage(event)" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button onclick="nextImage(event)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <img id="lightbox-img" src="" alt="" class="max-h-[85vh] max-w-[90vw] object-contain">
                    <div id="lightbox-caption" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white text-sm text-center"></div>
                </div>

                <script>
                    const images = @json($imagesJson);
                    let currentIndex = 0;

                    function openLightbox(index) {
                        currentIndex = index;
                        showImage();
                        document.getElementById('lightbox').classList.remove('hidden');
                        document.getElementById('lightbox').classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeLightbox(e) {
                        if (e.target === document.getElementById('lightbox') || e.currentTarget.tagName === 'BUTTON') {
                            document.getElementById('lightbox').classList.add('hidden');
                            document.getElementById('lightbox').classList.remove('flex');
                            document.body.style.overflow = '';
                        }
                    }

                    function prevImage(e) { e.stopPropagation(); currentIndex = (currentIndex - 1 + images.length) % images.length; showImage(); }
                    function nextImage(e) { e.stopPropagation(); currentIndex = (currentIndex + 1) % images.length; showImage(); }

                    function showImage() {
                        const img = images[currentIndex];
                        document.getElementById('lightbox-img').src = img.src;
                        document.getElementById('lightbox-img').alt = img.title || '';
                        const caption = [img.title, img.description].filter(Boolean).join(' — ');
                        document.getElementById('lightbox-caption').textContent = caption;
                    }

                    document.addEventListener('keydown', function(e) {
                        if (document.getElementById('lightbox').classList.contains('hidden')) return;
                        if (e.key === 'Escape') { document.getElementById('lightbox').classList.add('hidden'); document.getElementById('lightbox').classList.remove('flex'); document.body.style.overflow = ''; }
                        if (e.key === 'ArrowLeft') { currentIndex = (currentIndex - 1 + images.length) % images.length; showImage(); }
                        if (e.key === 'ArrowRight') { currentIndex = (currentIndex + 1) % images.length; showImage(); }
                    });
                </script>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-gray-500">Photos will be published here after the event.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3"><img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-8 brightness-0 invert opacity-60"><span class="text-sm">International Sales Meeting 2026</span></div>
                <div class="flex flex-wrap gap-6 text-sm"><a href="{{ route('kontakt') }}" class="hover:text-white transition">Contact</a><a href="https://www.muehlen-sohn.de" target="_blank" class="hover:text-white transition">muehlen-sohn.de</a></div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">&copy; 2026 Mühlen Sohn. All rights reserved.</div>
        </div>
    </footer>

    <script>document.getElementById('menu-toggle').addEventListener('click', function() { document.getElementById('mobile-menu').classList.toggle('hidden'); });</script>
</body>
</html>
