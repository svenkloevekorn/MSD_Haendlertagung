<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt – Händlertagung 2026 | Mühlen Sohn</title>
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
                <a href="{{ route('startseite') }}" class="hover:text-gray-900 transition">Startseite</a>
                <a href="{{ route('agenda') }}" class="hover:text-gray-900 transition">Agenda</a>
                <a href="{{ route('formular') }}" class="hover:text-gray-900 transition">Anmeldung</a>
                <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Galerie</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
                <a href="{{ route('feedback') }}" class="hover:text-gray-900 transition">Feedback</a>
                <a href="{{ route('kontakt') }}" class="text-gray-900">Kontakt</a>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Abmelden">
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
                <a href="{{ route('startseite') }}">Startseite</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}">Anmeldung</a><a href="{{ route('galerie') }}">Galerie</a><a href="{{ route('downloads') }}">Downloads</a><a href="{{ route('feedback') }}">Feedback</a><a href="{{ route('kontakt') }}" class="text-gray-900">Kontakt</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600">Abmelden</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Wir sind für Sie da</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kontakt</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Bei Fragen zur Händlertagung stehen Ihnen unsere Ansprechpartner gerne zur Verfügung.</p>
        </div>
    </section>

    <!-- Ansprechpartner -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Ansprechpartner</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Person 1 -->
                <div class="p-6 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Ansprechpartner 1</h3>
                    <p class="text-sm text-gray-400 mt-1">Position / Abteilung</p>
                    <div class="mt-4 space-y-2">
                        <a href="mailto:info@muehlen-sohn.de" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@muehlen-sohn.de
                        </a>
                        <a href="tel:+49000000" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +49 (0) 000 000
                        </a>
                    </div>
                </div>
                <!-- Person 2 -->
                <div class="p-6 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Ansprechpartner 2</h3>
                    <p class="text-sm text-gray-400 mt-1">Position / Abteilung</p>
                    <div class="mt-4 space-y-2">
                        <a href="mailto:info@muehlen-sohn.de" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@muehlen-sohn.de
                        </a>
                        <a href="tel:+49000000" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +49 (0) 000 000
                        </a>
                    </div>
                </div>
                <!-- Person 3 -->
                <div class="p-6 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Ansprechpartner 3</h3>
                    <p class="text-sm text-gray-400 mt-1">Position / Abteilung</p>
                    <div class="mt-4 space-y-2">
                        <a href="mailto:info@muehlen-sohn.de" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@muehlen-sohn.de
                        </a>
                        <a href="tel:+49000000" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +49 (0) 000 000
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontaktformular -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Nachricht senden</h2>
            <form class="space-y-5">
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Name *</label>
                        <input type="text" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">E-Mail *</label>
                        <input type="email" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition bg-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Betreff</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nachricht *</label>
                    <textarea rows="5" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition bg-white"></textarea>
                </div>
                <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition text-sm">
                    Nachricht absenden
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3"><img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-8 brightness-0 invert opacity-60"><span class="text-sm">Händlertagung 2026</span></div>
                <div class="flex flex-wrap gap-6 text-sm"><a href="{{ route('kontakt') }}" class="hover:text-white transition">Kontakt</a><a href="https://www.muehlen-sohn.de" target="_blank" class="hover:text-white transition">muehlen-sohn.de</a></div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">&copy; 2026 Mühlen Sohn. Alle Rechte vorbehalten.</div>
        </div>
    </footer>

    <script>document.getElementById('menu-toggle').addEventListener('click', function() { document.getElementById('mobile-menu').classList.toggle('hidden'); });</script>
</body>
</html>
