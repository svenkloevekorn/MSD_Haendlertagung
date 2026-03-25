<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads – Händlertagung 2026 | Mühlen Sohn</title>
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
                <a href="{{ route('downloads') }}" class="text-gray-900">Downloads</a>
                <a href="{{ route('feedback') }}" class="hover:text-gray-900 transition">Feedback</a>
                <a href="{{ route('kontakt') }}" class="hover:text-gray-900 transition">Kontakt</a>
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
                <a href="{{ route('startseite') }}">Startseite</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}">Anmeldung</a><a href="{{ route('galerie') }}">Galerie</a><a href="{{ route('downloads') }}" class="text-gray-900">Downloads</a><a href="{{ route('feedback') }}">Feedback</a><a href="{{ route('kontakt') }}">Kontakt</a>
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
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Materialien</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Downloads</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Präsentationen und Unterlagen der Händlertagung 2026.</p>
        </div>
    </section>

    <!-- Downloads Liste -->
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            @if($downloads->count() > 0)
                <div class="space-y-4">
                    @foreach($downloads as $download)
                        <a href="{{ route('downloads.file', $download) }}" class="flex items-center gap-4 p-5 bg-gray-50 rounded-xl border border-gray-100 hover:bg-gray-100 hover:border-gray-200 transition group">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                                @switch($download->file_extension)
                                    @case('pdf') bg-red-100 @break
                                    @case('xls') @case('xlsx') bg-green-100 @break
                                    @case('ppt') @case('pptx') bg-orange-100 @break
                                    @case('zip') bg-yellow-100 @break
                                    @case('jpg') @case('jpeg') @case('png') @case('webp') bg-blue-100 @break
                                    @default bg-gray-200
                                @endswitch
                            ">
                                @switch($download->file_extension)
                                    @case('pdf')
                                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        @break
                                    @case('xls') @case('xlsx')
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M3 14h18M9 4v16M15 4v16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                                        @break
                                    @case('ppt') @case('pptx')
                                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        @break
                                    @case('zip')
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/></svg>
                                        @break
                                    @case('jpg') @case('jpeg') @case('png') @case('webp')
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @break
                                    @default
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @endswitch
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 text-sm">{{ $download->name }}</h3>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ strtoupper($download->file_extension) }} · {{ $download->formatted_file_size }}
                                    @if($download->description)
                                        · {{ $download->description }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-gray-300 group-hover:text-gray-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-gray-500">Downloads werden nach der Veranstaltung freigeschaltet.</p>
                    </div>
                </div>
            @endif
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
