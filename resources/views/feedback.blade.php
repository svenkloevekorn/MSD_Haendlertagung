<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback – International Sales Meeting 2026 | Mühlen Sohn</title>
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
                <a href="{{ route('galerie') }}" class="hover:text-gray-900 transition">Gallery</a>
                <a href="{{ route('downloads') }}" class="hover:text-gray-900 transition">Downloads</a>
                <a href="{{ route('feedback') }}" class="text-gray-900">Feedback</a>
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
                <a href="{{ route('startseite') }}">Home</a><a href="{{ route('agenda') }}">Agenda</a><a href="{{ route('formular') }}">Registration</a><a href="{{ route('galerie') }}">Gallery</a><a href="{{ route('downloads') }}">Downloads</a><a href="{{ route('feedback') }}" class="text-gray-900">Feedback</a><a href="{{ route('kontakt') }}">Contact</a>
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
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-400 mb-4">Your Opinion</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Feedback</h1>
            <p class="text-lg text-gray-500 max-w-2xl">Your feedback helps us make future events even better.</p>
        </div>
    </section>

    <!-- Feedback Form -->
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
            <form method="POST" action="{{ route('feedback.submit') }}" class="space-y-8">
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

                <!-- Overall Impression -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Overall Impression</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">How would you rate the event overall? *</label>
                        <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', '') }}">
                        <div class="flex gap-2" id="star-rating">
                            @for($i = 1; $i <= 4; $i++)
                                <button type="button" data-star="{{ $i }}" class="star-btn p-1 transition" aria-label="{{ $i }} stars">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                </button>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Category Ratings -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Rate the Categories</h2>
                    <div class="space-y-6">
                        @foreach([
                            'accommodation' => 'Accommodation',
                            'catering' => 'Food & Catering',
                            'program' => 'Program',
                            'presentations' => 'Presentations',
                            'organisation' => 'Organisation',
                            'further' => 'Further',
                        ] as $key => $label)
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
                                    <input type="hidden" name="rating_{{ $key }}" class="category-rating-value" data-category="{{ $key }}" value="{{ old('rating_' . $key, '') }}">
                                    <div class="flex gap-1 category-stars" data-category="{{ $key }}">
                                        @for($i = 1; $i <= 4; $i++)
                                            <button type="button" data-star="{{ $i }}" data-category="{{ $key }}" class="cat-star-btn p-0.5 transition" aria-label="{{ $i }} stars">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                            </button>
                                        @endfor
                                    </div>
                                </div>
                                <textarea name="comment_{{ $key }}" rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition" placeholder="Comment (optional)">{{ old('comment_' . $key) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- In Detail -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">In Detail</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">What did you particularly enjoy?</label>
                            <textarea name="liked" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">{{ old('liked') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">What can we improve?</label>
                            <textarea name="improve" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">{{ old('improve') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">What topics would you like to see at the next meeting?</label>
                            <textarea name="topics" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">{{ old('topics') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Other -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-100">Other</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Additional Comments</label>
                        <textarea name="additional_comments" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">{{ old('additional_comments') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition text-sm">
                    Submit Feedback
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

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() { document.getElementById('mobile-menu').classList.toggle('hidden'); });

        // Star rating
        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-value');
        let currentRating = parseInt(ratingInput?.value) || 0;

        function updateStars(rating) {
            starBtns.forEach(btn => {
                const star = parseInt(btn.dataset.star);
                const svg = btn.querySelector('svg');
                if (star <= rating) {
                    svg.setAttribute('fill', '#F59E0B');
                    svg.setAttribute('stroke', '#F59E0B');
                } else {
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', 'currentColor');
                }
            });
        }

        if (starBtns.length) {
            updateStars(currentRating);

            starBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    currentRating = parseInt(this.dataset.star);
                    ratingInput.value = currentRating;
                    updateStars(currentRating);
                });
                btn.addEventListener('mouseenter', function() {
                    updateStars(parseInt(this.dataset.star));
                });
                btn.addEventListener('mouseleave', function() {
                    updateStars(currentRating);
                });
            });
        }

        // Category star ratings
        const categories = {};
        document.querySelectorAll('.category-rating-value').forEach(input => {
            categories[input.dataset.category] = parseInt(input.value) || 0;
        });

        function updateCategoryStars(category, rating) {
            document.querySelectorAll(`.cat-star-btn[data-category="${category}"]`).forEach(btn => {
                const star = parseInt(btn.dataset.star);
                const svg = btn.querySelector('svg');
                if (star <= rating) {
                    svg.setAttribute('fill', '#F59E0B');
                    svg.setAttribute('stroke', '#F59E0B');
                } else {
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', 'currentColor');
                }
            });
        }

        Object.keys(categories).forEach(cat => updateCategoryStars(cat, categories[cat]));

        document.querySelectorAll('.cat-star-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const cat = this.dataset.category;
                categories[cat] = parseInt(this.dataset.star);
                document.querySelector(`.category-rating-value[data-category="${cat}"]`).value = categories[cat];
                updateCategoryStars(cat, categories[cat]);
            });
            btn.addEventListener('mouseenter', function() {
                updateCategoryStars(this.dataset.category, parseInt(this.dataset.star));
            });
            btn.addEventListener('mouseleave', function() {
                updateCategoryStars(this.dataset.category, categories[this.dataset.category]);
            });
        });
    </script>
</body>
</html>
