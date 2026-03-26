<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda – Händlertagung 2026 | Mühlen Sohn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#0EA039',
                            dark: '#565656',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-800 antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('startseite') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-10">
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="{{ route('startseite') }}" class="hover:text-gray-900 transition">Startseite</a>
                <a href="{{ route('agenda') }}" class="text-gray-900">Agenda</a>
                <a href="{{ route('formular') }}" class="hover:text-gray-900 transition">Anmeldung</a>
                <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Galerie</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
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
            <button id="menu-toggle" class="md:hidden p-2 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-6 py-4 flex flex-col gap-3 text-sm font-medium text-gray-600">
                <a href="{{ route('startseite') }}" class="hover:text-gray-900">Startseite</a>
                <a href="{{ route('agenda') }}" class="text-gray-900">Agenda</a>
                <a href="{{ route('formular') }}" class="hover:text-gray-900">Anmeldung</a>
                <a href="{{ route('galerie') }}" class="hover:text-gray-900">Galerie</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900">Downloads</a>
                <a href="{{ route('feedback') }}" class="hover:text-gray-900">Feedback</a>
                <a href="{{ route('kontakt') }}" class="hover:text-gray-900">Kontakt</a>
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
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Programm</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Agenda</h1>
            <p class="text-lg text-gray-500 max-w-2xl">
                Vier Tage voller Programm – von Fachvorträgen über Networking bis hin zu optionalen Aktivitäten.
            </p>
        </div>
    </section>

    <!-- Tab Navigation -->
    <section class="sticky top-[73px] bg-white border-b border-gray-200 z-40">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex gap-1 overflow-x-auto" id="day-tabs">
                @foreach($days as $day)
                    <button data-day="day-{{ $day->id }}" class="day-tab px-5 py-4 text-sm font-medium {{ $loop->first ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-400 border-b-2 border-transparent hover:text-gray-600' }} whitespace-nowrap">
                        {{ $day->tab_label }}
                    </button>
                @endforeach
                <button data-day="partner" class="day-tab px-5 py-4 text-sm font-medium text-gray-400 border-b-2 border-transparent hover:text-gray-600 whitespace-nowrap">
                    Partnerprogramm
                </button>
            </div>
        </div>
    </section>

    <!-- Agenda Content -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            @foreach($days as $day)
                <div id="day-{{ $day->id }}" class="day-content {{ $loop->first ? '' : 'hidden' }}">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-2xl flex flex-col items-center justify-center">
                            <span class="text-xs font-medium text-gray-400 uppercase leading-none">{{ $day->date->locale('de')->shortDayName }}</span>
                            <span class="text-xl font-bold text-gray-900 leading-none mt-0.5">{{ $day->date->format('d') }}</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $day->title }}</h2>
                            @if($day->subtitle)
                                <p class="text-gray-400 text-sm">{{ $day->subtitle }}</p>
                            @endif
                        </div>
                    </div>
                    @if($day->items->count())
                        <div class="space-y-0 ml-8 border-l-2 border-gray-100 pl-8">
                            @foreach($day->items as $item)
                                <div class="relative {{ $loop->last ? 'pb-4' : 'pb-10' }}">
                                    <div class="absolute -left-[41px] top-1 w-4 h-4 rounded-full bg-white border-2 border-gray-300"></div>
                                    @if($item->overline)
                                        <p class="text-sm font-medium text-gray-400 mb-1">{{ $item->overline }}</p>
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h3>
                                    @if($item->description)
                                        <p class="text-gray-500 text-sm mt-1">{{ $item->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Partnerprogramm -->
            <div id="partner" class="day-content hidden">
                <div class="flex items-center gap-4 mb-10">
                    <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-2xl flex flex-col items-center justify-center">
                        <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Partnerprogramm</h2>
                        <p class="text-gray-400 text-sm">Dienstag & Mittwoch · 09:00 – 17:00 Uhr</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8">
                    <p class="text-gray-500 leading-relaxed">
                        Für die Begleitpersonen unserer Teilnehmer bieten wir an beiden Tagungstagen ein eigenes Programm an.
                        Details werden in Kürze bekannt gegeben.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 border border-gray-200">Dienstag, 29.06.</span>
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 border border-gray-200">Mittwoch, 30.06.</span>
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 border border-gray-200">jeweils 09:00 – 17:00 Uhr</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Speaker Übersicht -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Speaker</h2>
            <p class="text-gray-500 mb-12">Unsere externen Gastredner auf der Händlertagung 2026.</p>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Speaker Placeholder Cards -->
                <div class="bg-white rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Wird bekannt gegeben</h3>
                    <p class="text-sm text-gray-400 mt-1">Guest Speaker – Paper</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Wird bekannt gegeben</h3>
                    <p class="text-sm text-gray-400 mt-1">Guest Speaker – Glue</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Wird bekannt gegeben</h3>
                    <p class="text-sm text-gray-400 mt-1">Guest Speaker</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Wird bekannt gegeben</h3>
                    <p class="text-sm text-gray-400 mt-1">Guest Speaker</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-8 brightness-0 invert opacity-60">
                    <span class="text-sm">Händlertagung 2026</span>
                </div>
                <div class="flex flex-wrap gap-6 text-sm">
                    <a href="{{ route('kontakt') }}" class="hover:text-white transition">Kontakt</a>
                    <a href="https://www.muehlen-sohn.de" target="_blank" class="hover:text-white transition">muehlen-sohn.de</a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
                &copy; 2026 Mühlen Sohn. Alle Rechte vorbehalten.
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Day tabs
        document.querySelectorAll('.day-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Reset all tabs
                document.querySelectorAll('.day-tab').forEach(t => {
                    t.classList.remove('text-gray-900', 'border-gray-900');
                    t.classList.add('text-gray-400', 'border-transparent');
                });
                // Activate clicked tab
                this.classList.remove('text-gray-400', 'border-transparent');
                this.classList.add('text-gray-900', 'border-gray-900');
                // Hide all content
                document.querySelectorAll('.day-content').forEach(c => c.classList.add('hidden'));
                // Show selected content
                document.getElementById(this.dataset.day).classList.remove('hidden');
            });
        });
    </script>

</body>
</html>
