<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration – International Sales Meeting 2026 | Mühlen Sohn</title>
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
                <a href="{{ route('formular') }}" class="text-gray-900">Registration</a>
                <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Gallery</a>
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
                <a href="{{ route('startseite') }}">Home</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}" class="text-gray-900">Registration</a><a href="{{ route('galerie') }}">Gallery</a><a href="{{ route('downloads') }}">Downloads</a><a href="{{ route('feedback') }}">Feedback</a><a href="{{ route('kontakt') }}">Contact</a>
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
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Participants</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Registration</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Please fill out the following form completely. Your information helps us with the organisation.</p>
        </div>
    </section>

    <!-- Formular -->
    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-6">
            @if(session('success'))
                <div class="mb-8 p-6 bg-brand-green/10 border border-brand-green/20 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-gray-700">{{ session('success') }}</p>
                    </div>
                </div>
            @else
            <form method="POST" action="{{ route('formular.submit') }}" class="space-y-8">
                @csrf

                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Personal Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Personal Details</h2>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mobile Number *</label>
                            <input type="tel" name="mobile" value="{{ old('mobile') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="+49 ...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Company</label>
                            <input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        </div>
                    </div>
                </div>

                <!-- Accompanying Person -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Accompanying Person</h2>
                    <div class="space-y-5">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="has_companion" id="partner-check" value="1" {{ old('has_companion') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-200">
                            <label for="partner-check" class="text-sm text-gray-700">I am bringing an accompanying person</label>
                        </div>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name (Companion)</label>
                                <input type="text" name="companion_first_name" value="{{ old('companion_first_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name (Companion)</label>
                                <input type="text" name="companion_last_name" value="{{ old('companion_last_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catering -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Catering</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Intolerances / Allergies</label>
                        <textarea name="allergies" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="e.g. lactose intolerance, nut allergy, vegetarian ...">{{ old('allergies') }}</textarea>
                    </div>
                </div>

                <!-- Optional Participation -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Optional Participation</h2>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="factory_tour" id="factory-tour" value="1" {{ old('factory_tour') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-200">
                            <label for="factory-tour" class="text-sm text-gray-700">Factory tour on Thursday (incl. bus transfer)</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="whatsapp" id="whatsapp" value="1" {{ old('whatsapp') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-200">
                            <label for="whatsapp" class="text-sm text-gray-700">Join the WhatsApp group</label>
                        </div>
                    </div>
                </div>

                <!-- Other -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Other</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Comments</label>
                        <textarea name="comments" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="Any other notes or requests ...">{{ old('comments') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition text-sm">
                    Submit Registration
                </button>
            </form>
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
