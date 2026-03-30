<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mühlen Sohn – International Sales Meeting 2026</title>
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
        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
            <a href="{{ route('startseite') }}" class="text-gray-900">Home</a>
            <a href="{{ route('agenda') }}" class="hover:text-gray-900 transition">Agenda</a>
            <a href="{{ route('formular') }}" class="hover:text-gray-900 transition">Registration</a>
            <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Gallery</a>
            <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
            <a href="{{ route('feedback') }}" class="hover:text-gray-900 transition">Feedback</a>
            <a href="{{ route('kontakt') }}" class="hover:text-gray-900 transition">Contact</a>
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Log out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
        <!-- Mobile Menu Button -->
        <button id="menu-toggle" class="md:hidden p-2 text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
    <!-- Mobile Nav -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-6 py-4 flex flex-col gap-3 text-sm font-medium text-gray-600">
            <a href="{{ route('startseite') }}" class="text-gray-900">Home</a>
            <a href="{{ route('agenda') }}" class="hover:text-gray-900">Agenda</a>
            <a href="{{ route('formular') }}" class="hover:text-gray-900">Registration</a>
            <a href="{{ route('galerie') }}" class="hover:text-gray-900">Gallery</a>
            <a href="{{ route('downloads') }}" class="hover:text-gray-900">Downloads</a>
            <a href="{{ route('feedback') }}" class="hover:text-gray-900">Feedback</a>
            <a href="{{ route('kontakt') }}" class="hover:text-gray-900">Contact</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-600">Log out</button>
            </form>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/bg.jpeg') }}');">
    <div class="absolute inset-0 mix-blend-multiply" style="background: linear-gradient(to right, rgba(0,0,0,0.9), rgba(0,0,0,0.4));"></div>
    <div class="relative max-w-6xl mx-auto px-6">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-widest text-white/70 mb-4">June 29 – July 02, 2026</p>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                International Sales Meeting
                <span class="text-white/50 font-light">2026</span>
            </h1>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed mb-10 max-w-2xl">
                @if($dealer)
                    Welcome, {{ $dealer->first_name }} {{ $dealer->last_name }}!
                @endif
                We cordially invite you to this year’s International Sales Meeting. Three days filled with discussion, insights,
                and shared experiences.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('agenda') }}"
                   class="inline-flex items-center px-6 py-3 bg-white text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-100 transition">
                    View the agenda
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('formular') }}"
                   class="inline-flex items-center px-6 py-3 border border-white/40 text-white text-sm font-medium rounded-lg hover:border-white/70 transition">
                    To register
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Überblick -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-12">At a glance</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Karte 1 -->
            <div class="p-8 bg-gray-50 rounded-2xl">
                <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Date</h3>
                <p class="text-gray-500 leading-relaxed">
                    Monday, June 29 – Thursday, July 02, 2026<br>
                    <span class="text-sm text-gray-400">Conference days: Tuesday & Wednesday</span>
                </p>
            </div>
            <!-- Karte 2 -->
            <div class="p-8 bg-gray-50 rounded-2xl">
                <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hotel</h3>
                <p class="text-gray-500 leading-relaxed">
                    Hotel Lago<br>
                    <span class="text-sm text-gray-400">Check-in: Mo, 28.06. · Check-out: Do, 01.07.</span>
                </p>
            </div>
            <!-- Karte 3 -->
            <div class="p-8 bg-gray-50 rounded-2xl">
                <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Location</h3>
                <p class="text-gray-500 leading-relaxed">
                    To be announced<br>
                    <span class="text-sm text-gray-400">Details to follow shortly</span>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Hotelhinweis -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="max-w-3xl">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Hotel Reservation</h2>
            <p class="text-gray-500 leading-relaxed mb-6">
                We have reserved rooms at Hotel Lago for all participants –
                from <strong class="text-gray-700">Monday, June 29</strong> to <strong class="text-gray-700">Thursday,
                    July 02, 2026</strong>.
            </p>
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900 mb-1">Important Notice</p>
                        <p class="text-sm text-gray-500">
                            If you wish to arrive earlier or stay longer, please book the additional
                            nights directly with the hotel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dresscode -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="max-w-3xl">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Dresscode</h2>
            <p class="text-gray-500 leading-relaxed">
                Business Casual – Details to be added.
            </p>
        </div>
    </div>
</section>

<!-- Quick-Links -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-12">Further Information</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('agenda') }}"
               class="group p-6 bg-white rounded-xl border border-gray-200 hover:border-gray-300 transition">
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-600 transition">Agenda</h3>
                <p class="text-sm text-gray-400">Programme & Speakers</p>
            </a>
            <a href="{{ route('formular') }}"
               class="group p-6 bg-white rounded-xl border border-gray-200 hover:border-gray-300 transition">
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-600 transition">Registration</h3>
                <p class="text-sm text-gray-400">Participant Form</p>
            </a>
            <a href="{{ route('galerie') }}"
               class="group p-6 bg-white rounded-xl border border-gray-200 hover:border-gray-300 transition">
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-600 transition">Gallery</h3>
                <p class="text-sm text-gray-400">Event Photos</p>
            </a>
            <a href="{{ route('kontakt') }}"
               class="group p-6 bg-white rounded-xl border border-gray-200 hover:border-gray-300 transition">
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-gray-600 transition">Contact</h3>
                <p class="text-sm text-gray-400">Contact Persons</p>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-12 bg-gray-900 text-gray-400">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn"
                     class="h-8 brightness-0 invert opacity-60">
                <span class="text-sm">International Sales Meeting 2026</span>
            </div>
            <div class="flex flex-wrap gap-6 text-sm">
                <a href="{{ route('kontakt') }}" class="hover:text-white transition">Contact</a>
                <a href="https://www.muehlen-sohn.de" target="_blank" class="hover:text-white transition">muehlen-sohn.de</a>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
            &copy; 2026 Mühlen Sohn. All rights reserved.
        </div>
    </div>
</footer>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>

</body>
</html>
