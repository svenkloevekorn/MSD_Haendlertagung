<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration – International Sales Meeting 2026 | Mühlen Sohn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <a href="{{ route('market-info') }}" class="hover:text-gray-900 transition">Market Info</a>
                <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Gallery</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
                <a href="{{ route('feedback') }}" class="hover:text-gray-900 transition">Feedback</a>
                <a href="{{ route('kontakt') }}" class="hover:text-gray-900 transition">Contact</a>
                @include('partials.todo-badge')
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
                <a href="{{ route('startseite') }}">Home</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}" class="text-gray-900">Registration</a><a href="{{ route('market-info') }}" class="hover:text-gray-900">Market Info</a><a href="{{ route('galerie') }}">Gallery</a><a href="{{ route('downloads') }}">Downloads</a><a href="{{ route('feedback') }}">Feedback</a><a href="{{ route('kontakt') }}">Contact</a>
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
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Your Event Details</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Please fill out the following form completely. Your information helps us with the organisation.</p>
        </div>
    </section>

    <!-- Formular -->
    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-6">
            @if($dealer->is_internal)
                <div class="p-6 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-medium text-gray-900">No action required</p>
                            <p class="text-sm text-gray-600 mt-1">As an internal participant, you do not need to fill out this form.</p>
                        </div>
                    </div>
                </div>
            @else
            @if(session('success'))
                <div class="mb-8 p-6 bg-brand-green/10 border border-brand-green/20 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-gray-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Progress Checklist -->
            @php
                $hasCompanionHandled = ($saved['no_companion'] ?? '') === 'true' || ! empty($saved['companion_mobile'] ?? null);
                $hasPhone = ! empty($saved['mobile'] ?? null) && $hasCompanionHandled;
                $hasActivities = ($saved['no_companion'] ?? '') === 'true' || (! empty($saved['activity_1'] ?? null) && ! empty($saved['activity_2'] ?? null) && ! empty($saved['activity_3'] ?? null));
                $hasAllergies = ! empty($saved['allergies'] ?? null) || ($saved['no_allergies'] ?? '') === 'true';
                $hasFactoryTour = ! empty($saved['factory_tour'] ?? null);
            @endphp
            <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Registration Progress</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        @if($hasFactoryTour)
                            <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        @endif
                        <span class="text-sm {{ $hasFactoryTour ? 'text-gray-700' : 'text-gray-400' }}">Factory Tour – <strong>Deadline: May 1, 2026</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($hasActivities)
                            <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        @endif
                        <span class="text-sm {{ $hasActivities ? 'text-gray-700' : 'text-gray-400' }}">Activities Ranking – <strong>Deadline: May 1, 2026</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($hasAllergies)
                            <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        @endif
                        <span class="text-sm {{ $hasAllergies ? 'text-gray-700' : 'text-gray-400' }}">Intolerances / Allergies – <strong>Deadline: June 1, 2026</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($hasPhone)
                            <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        @endif
                        <span class="text-sm {{ $hasPhone ? 'text-gray-700' : 'text-gray-400' }}">Mobile Numbers (you & companion) – <strong>Deadline: June 10, 2026</strong></span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('formular.submit') }}" class="space-y-8" novalidate>
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

                <!-- Personal Details (read-only from dealer) -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Personal Details</h2>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name</label>
                            <input type="text" value="{{ $dealer->first_name }}" readonly class="w-full px-4 py-3 border border-gray-100 rounded-lg text-sm bg-gray-50 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name</label>
                            <input type="text" value="{{ $dealer->last_name }}" readonly class="w-full px-4 py-3 border border-gray-100 rounded-lg text-sm bg-gray-50 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="text" value="{{ $dealer->email }}" readonly class="w-full px-4 py-3 border border-gray-100 rounded-lg text-sm bg-gray-50 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mobile Number</label>
                            <input type="tel" name="mobile" value="{{ old('mobile', $saved['mobile'] ?? '') }}" pattern="\+[0-9\s\-]+" title="Please use international format starting with + (e.g. +49 171 1234567)" class="w-full px-4 py-3 border {{ $errors->has('mobile') ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="+49 171 1234567">
                            @error('mobile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @else
                                <p class="text-xs text-gray-400 mt-1">International format, e.g. +49 171 1234567</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Company</label>
                            <input type="text" name="company" value="{{ old('company', $saved['company'] ?? '') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        </div>
                    </div>
                </div>

                <!-- Accompanying Person + Activities -->
                <div x-data="{ noCompanion: {{ old('no_companion', $saved['no_companion'] ?? '') === 'true' ? 'true' : 'false' }} }">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Accompanying Person (Partner)</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="no-companion" name="no_companion" value="true" x-model="noCompanion" {{ old('no_companion', $saved['no_companion'] ?? '') === 'true' ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-200">
                            <label for="no-companion" class="text-sm text-gray-700">I am not bringing an accompanying person</label>
                        </div>
                        <div x-show="!noCompanion" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mobile Number (Accompanying Person)</label>
                            <input type="tel" name="companion_mobile" value="{{ old('companion_mobile', $saved['companion_mobile'] ?? '') }}" pattern="\+[0-9\s\-]+" title="Please use international format starting with + (e.g. +49 171 1234567)" class="w-full px-4 py-3 border {{ $errors->has('companion_mobile') ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="+49 171 1234567">
                            @error('companion_mobile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @else
                                <p class="text-xs text-gray-400 mt-1">International format, e.g. +49 171 1234567</p>
                            @enderror
                        </div>
                    </div>

                <!-- Activities Ranking -->
                <div x-show="!noCompanion" x-transition>
                @php
                    $act1 = old('activity_1', $saved['activity_1'] ?? '');
                    $act2 = old('activity_2', $saved['activity_2'] ?? '');
                    $act3 = old('activity_3', $saved['activity_3'] ?? '');
                @endphp
                <div x-data="{
                    ranking: [
                        '{{ $act1 }}',
                        '{{ $act2 }}',
                        '{{ $act3 }}'
                    ].filter(v => v !== ''),
                    options: [
                        {
                            id: 'kessler',
                            title: 'Guided cellar tour at Kessler – Germany\'s oldest sparkling wine brand',
                            description: 'Discover the historic Kessler sparkling wine cellars on a guided tour. Learn about traditional sparkling wine production, explore the atmospheric vaulted cellars, and gain insight into the heritage of Germany\'s oldest sparkling wine brand.'
                        },
                        {
                            id: 'meersburg',
                            title: 'Visit to Meersburg Castle on Lake Constance – Germany\'s oldest inhabited castle',
                            description: 'Explore Meersburg Castle, dramatically located above Lake Constance. Walk through its historic rooms and courtyards, enjoy impressive views over the lake, and delve into the castle\'s long and fascinating history.'
                        },
                        {
                            id: 'alpsee',
                            title: 'Easy walk in the Alpsee Bergwelt with panoramic views of Lake Alpsee',
                            description: 'Enjoy an easy, relaxed walk in the Alpsee Bergwelt high above Lake Alpsee. From this elevated vantage point, you can take in beautiful panoramic views of the lake and the surrounding Alpine scenery, without any demanding hiking sections.'
                        }
                    ],
                    toggle(id) {
                        const idx = this.ranking.indexOf(id);
                        if (idx > -1) {
                            this.ranking.splice(idx, 1);
                        } else {
                            this.ranking.push(id);
                        }
                    },
                    rank(id) {
                        const idx = this.ranking.indexOf(id);
                        return idx > -1 ? idx + 1 : null;
                    }
                }">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Activities (Partner Program)</h2>
                    <p class="text-sm text-gray-500 mb-4">Please rank the following activities by clicking them in order of your preference (1st = most preferred).</p>
                    <div class="space-y-3">
                        <template x-for="option in options" :key="option.id">
                            <button type="button" @click="toggle(option.id)"
                                :class="rank(option.id) ? 'border-gray-900 bg-gray-50' : '{{ $errors->has('activity_1') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}'"
                                class="w-full flex items-start gap-4 p-4 border rounded-xl transition hover:border-gray-300 text-left">
                                <div :class="rank(option.id) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400'"
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 transition mt-0.5">
                                    <span x-text="rank(option.id) || '-'"></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900" x-text="option.title"></p>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed" x-text="option.description"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="activity_1" :value="ranking[0] || ''">
                    <input type="hidden" name="activity_2" :value="ranking[1] || ''">
                    <input type="hidden" name="activity_3" :value="ranking[2] || ''">
                    @error('activity_1')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-2">Click again to remove from ranking. Deadline: <strong>May 1, 2026</strong></p>
                </div>
                </div>
                </div>

                <!-- Catering -->
                <div x-data="{ noAllergies: {{ old('no_allergies', $saved['no_allergies'] ?? '') === 'true' ? 'true' : 'false' }} }">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Catering</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="no-allergies" name="no_allergies" value="true" x-model="noAllergies" {{ old('no_allergies', $saved['no_allergies'] ?? '') === 'true' ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-200">
                            <label for="no-allergies" class="text-sm text-gray-700">No intolerances or allergies</label>
                        </div>
                        <div x-show="!noAllergies" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Intolerances / Allergies</label>
                            <textarea name="allergies" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="e.g. lactose intolerance, nut allergy, vegetarian ...">{{ old('allergies', $saved['allergies'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Optional Factory Tour -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Optional Factory Tour</h2>
                    <p class="text-sm text-gray-500 mb-4">Thursday, July 2 – Factory tour at Mühlen Sohn (incl. bus transfer)</p>
                    @php $ft = old('factory_tour', $saved['factory_tour'] ?? ''); @endphp
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="factory_tour" value="yes" {{ $ft == 'yes' ? 'checked' : '' }} class="sr-only peer">
                            <div class="py-3 text-center border border-gray-200 rounded-lg text-sm text-gray-500 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition hover:border-gray-300">Yes, I would like to participate</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="factory_tour" value="no" {{ $ft == 'no' ? 'checked' : '' }} class="sr-only peer">
                            <div class="py-3 text-center border border-gray-200 rounded-lg text-sm text-gray-500 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition hover:border-gray-300">No, thank you</div>
                        </label>
                    </div>
                </div>

                <!-- Other -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Other</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Comments</label>
                        <textarea name="comments" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="Any other notes or requests ...">{{ old('comments', $saved['comments'] ?? '') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition text-sm">
                    Save Registration
                </button>
            </form>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3"><img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-8 brightness-0 invert opacity-60"></div>
                <div class="flex flex-wrap gap-6 text-sm"><a href="{{ route('kontakt') }}" class="hover:text-white transition">Contact</a><a href="https://www.muehlen-sohn.de" target="_blank" class="hover:text-white transition">muehlen-sohn.de</a></div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">&copy; 2026 Mühlen Sohn. All rights reserved.</div>
        </div>
    </footer>

    <script>document.getElementById('menu-toggle').addEventListener('click', function() { document.getElementById('mobile-menu').classList.toggle('hidden'); });</script>
</body>
</html>
