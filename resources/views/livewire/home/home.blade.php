{{--
    Home Page Component
    Main landing page with following sections:
    - Hero section with call-to-action
    - Why choose us features
    - Feature grid showcase
    - Statistics dashboard (for authenticated users)
    - User testimonials
    - Submit testimonial form (for authenticated users)
    - Final call-to-action
--}}

<div class="home-wrapper min-h-screen">
    {{-- Hero Section: Main landing area with action buttons --}}
    <div class="hero-section mb-12">
        <div class="hero-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="hero-content flex-col justify-center">
                <h1 class="flex hero-title mb-6 text-center">Master English Vocabulary Like Never Before</h1>
                <p class="flex hero-subtitle mb-8 mx-auto text-center">Join thousands of learners who have transformed
                    their language skills using
                    our personalized learning system</p>
                @auth
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('review') }}" class="start-review-btn">
                            <span class="material-symbols-outlined">auto_stories</span>
                            Start Review
                        </a>
                        <a href="{{ route('exam') }}" class="take-exam-btn">
                            <span class="material-symbols-outlined">quiz</span>
                            Take Exam
                        </a>
                    </div>
                @else
                    <a href="{{ route('register') }}" class="get-started-btn">
                        Start Learning for Free
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Why Choose Us: Key benefits and features overview --}}
    <div class="why-choose-us flex">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="section-title text-center mb-12">Why Choose LexiLift?</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="reason-card">
                    <span class="material-symbols-outlined text-accent-500">school</span>
                    <div>
                        <h3 class="font-semibold mb-2">Personalized Learning</h3>
                        <p class="text-secondary-text">Our system adapts to your learning pace and style</p>
                    </div>
                </div>
                <div class="reason-card">
                    <span class="material-symbols-outlined text-accent-500">schedule</span>
                    <div>
                        <h3 class="font-semibold mb-2">Learn at Your Pace</h3>
                        <p class="text-secondary-text">Flexible learning schedule that fits your lifestyle</p>
                    </div>
                </div>
                <div class="reason-card">
                    <span class="material-symbols-outlined text-accent-500">trending_up</span>
                    <div>
                        <h3 class="font-semibold mb-2">Track Progress</h3>
                        <p class="text-secondary-text">Detailed analytics to monitor your improvement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Features Grid: Detailed feature showcase --}}
    <div class="features-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card">
                    <span class="material-symbols-outlined">psychology</span>
                    <h3>Smart Review</h3>
                    <p>Systematic review that focuses on your weak points</p>
                </div>
                <div class="feature-card">
                    <span class="material-symbols-outlined">track_changes</span>
                    <h3>Progress Tracking</h3>
                    <p>Monitor your vocabulary growth with detailed statistics</p>
                </div>
                <div class="feature-card">
                    <span class="material-symbols-outlined">workspace_premium</span>
                    <h3>Regular Tests</h3>
                    <p>Challenge yourself with vocabulary exams to reinforce learning</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Dashboard: User progress visualization --}}
    @auth
        @if ($statistics)
            <div class="stats-section">
                {{-- Statistics header --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <h2 class="section-title text-center mb-12">Your Learning Journey</h2>
                    {{-- Statistics cards grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Mastered Words Stats Card --}}
                        <div
                            class="card-hover bg-[var(--secondary-base-clr)] rounded-xl shadow-lg overflow-hidden border-2 border-emerald-500">
                            <div class="p-6 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-emerald-500 text-sm font-semibold uppercase tracking-wider">
                                            Mastered</div>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                            {{ $statistics['mastered_words'] }} Words</h3>
                                    </div>
                                    <div class="flex bg-emerald-100 p-3 rounded-full items-center justify-center">
                                        <span class="material-symbols-outlined text-emerald-600">workspace_premium</span>
                                    </div>
                                </div>

                                <div class="mt-6 relative">
                                    <svg class="w-24 h-24 mx-auto" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor"
                                            fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="progress-ring__circle text-emerald-500" stroke-width="8"
                                            stroke-linecap="round" stroke="currentColor" fill="transparent" r="40"
                                            cx="50" cy="50" stroke-dasharray="251.2"
                                            stroke-dashoffset="calc(251.2 - (251.2 * {{ ($statistics['mastered_words'] / $statistics['total_words']) * 100 }}) / 100)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="progress-text text-2xl font-bold text-[var(--text-clr)]">{{ round(($statistics['mastered_words'] / $statistics['total_words']) * 100) }}%</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Strong knowledge</span>
                                        <span
                                            class="font-medium">{{ $statistics['mastered_words'] }}/{{ $statistics['total_words'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full"
                                            style="width: {{ ($statistics['mastered_words'] / $statistics['total_words']) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('review', ['word_level' => 'strong']) }}"
                                    class="mt-6 w-full py-2 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined mr-2">auto_stories</span> Review
                                </a>
                            </div>
                        </div>

                        {{-- Learning Words Stats Card --}}
                        <div
                            class="card-hover bg-[var(--secondary-base-clr)] rounded-xl shadow-lg overflow-hidden border-2 border-blue-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-blue-500 text-sm font-semibold uppercase tracking-wider">Learning
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                            {{ $statistics['learning_words'] }} Words</h3>
                                    </div>
                                    <div class="flex items-center justify-center bg-blue-100 p-3 rounded-full">
                                        <span class="material-symbols-outlined text-blue-600">psychology</span>
                                    </div>
                                </div>

                                <div class="mt-6 relative">
                                    <svg class="w-24 h-24 mx-auto" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor"
                                            fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="progress-ring__circle text-blue-500" stroke-width="8"
                                            stroke-linecap="round" stroke="currentColor" fill="transparent" r="40"
                                            cx="50" cy="50" stroke-dasharray="251.2"
                                            stroke-dashoffset="calc(251.2 - (251.2 * {{ ($statistics['learning_words'] / $statistics['total_words']) * 100 }}) / 100)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="progress-text text-2xl font-bold text-[var(--text-clr)]">{{ round(($statistics['learning_words'] / $statistics['total_words']) * 100) }}%</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>In progress</span>
                                        <span
                                            class="font-medium">{{ $statistics['learning_words'] }}/{{ $statistics['total_words'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full"
                                            style="width: {{ ($statistics['learning_words'] / $statistics['total_words']) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('review', ['word_level' => 'medium']) }}"
                                    class="mt-6 w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined mr-2">auto_stories</span> Review
                                </a>
                            </div>
                        </div>

                        {{-- Practice Needed Stats Card --}}
                        <div
                            class="card-hover bg-[var(--secondary-base-clr)] rounded-xl shadow-lg overflow-hidden border-2 border-amber-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-amber-500 text-sm font-semibold uppercase tracking-wider">Needs
                                            Practice</div>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $statistics['weak_words'] }}
                                            Words</h3>
                                    </div>
                                    <div class="flex items-center justify-center bg-amber-100 p-3 rounded-full">
                                        <span class="material-symbols-outlined text-amber-600">error</span>
                                    </div>
                                </div>

                                <div class="mt-6 relative">
                                    <svg class="w-24 h-24 mx-auto" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor"
                                            fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="progress-ring__circle text-amber-500" stroke-width="8"
                                            stroke-linecap="round" stroke="currentColor" fill="transparent" r="40"
                                            cx="50" cy="50" stroke-dasharray="251.2"
                                            stroke-dashoffset="calc(251.2 - (251.2 * {{ ($statistics['weak_words'] / $statistics['total_words']) * 100 }}) / 100)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="progress-text text-2xl font-bold text-[var(--text-clr)]">{{ round(($statistics['weak_words'] / $statistics['total_words']) * 100) }}%</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Review needed</span>
                                        <span
                                            class="font-medium">{{ $statistics['weak_words'] }}/{{ $statistics['total_words'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-500 h-2 rounded-full"
                                            style="width: {{ ($statistics['weak_words'] / $statistics['total_words']) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('review', ['word_level' => 'weak']) }}"
                                    class="mt-6 w-full py-2 px-4 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined mr-2">auto_stories</span> Review
                                </a>
                            </div>
                        </div>

                        {{-- Total Words Stats Card --}}
                        <div
                            class="card-hover bg-[var(--secondary-base-clr)] rounded-xl shadow-lg overflow-hidden border-2 border-purple-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-purple-500 text-sm font-semibold uppercase tracking-wider">Total
                                            Words</div>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $statistics['total_words'] }}
                                            Words</h3>
                                    </div>
                                    <div class="flex items-center justify-center bg-purple-100 p-3 rounded-full">
                                        <span class="material-symbols-outlined text-purple-600">library_books</span>
                                    </div>
                                </div>

                                <div class="mt-6 relative">
                                    <svg class="w-24 h-24 mx-auto" viewBox="0 0 100 100">
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor"
                                            fill="transparent" r="40" cx="50" cy="50" />
                                        <circle class="progress-ring__circle text-purple-500" stroke-width="8"
                                            stroke-linecap="round" stroke="currentColor" fill="transparent" r="40"
                                            cx="50" cy="50" stroke-dasharray="251.2"
                                            stroke-dashoffset="calc(251.2 - (251.2 * 100) / 100)" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="progress-text text-2xl font-bold text-[var(--text-clr)]">100%</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Your vocabulary size</span>
                                        <span
                                            class="font-medium">{{ $statistics['total_words'] }}/{{ $statistics['total_words'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-500 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('review') }}"
                                    class="mt-6 w-full py-2 px-4 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined mr-2">auto_stories</span> Review All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- Testimonials Section: User feedback and ratings --}}
    <div class="testimonials-section py-12">
        {{-- Testimonials header with overall rating --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title">What Our Learners Say</h2>
                <p class="mt-3 text-xl text-gray-500">Join our community of successful English learners</p>
                <div class="mt-6 flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex mr-2">
                            <span class="material-icons-round text-2xl text-yellow-400">star</span>
                            <span class="material-icons-round text-2xl text-yellow-400">star</span>
                            <span class="material-icons-round text-2xl text-yellow-400">star</span>
                            <span class="material-icons-round text-2xl text-yellow-400">star</span>
                            <span class="material-icons-round text-2xl text-yellow-400">star_half</span>
                        </div>
                        <span class="text-gray-700 font-medium">4.7 from over 200 learners</span>
                    </div>
                </div>
            </div>

            {{-- Testimonial cards grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                {{-- Individual testimonial cards --}}
                <div class="testimonial-card fade-in">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover mr-4"
                            src="{{ asset('assets/image/testimonials/user1.jpg') }}" alt="Sarah Johnson">
                        <div>
                            <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
                            <div class="flex mt-1">
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"LexiLift made learning English vocabulary enjoyable. The smart
                        review system helps me focus on words I need to practice most."</p>
                    <div class="text-sm text-gray-400">2 weeks of learning</div>
                </div>

                <div class="testimonial-card fade-in">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover mr-4"
                            src="{{ asset('assets/image/testimonials/user1.jpg') }}" alt="Michael Chen">
                        <div>
                            <h4 class="font-semibold text-gray-800">Michael Chen</h4>
                            <div class="flex mt-1">
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-gray-300">star</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"The progress tracking is fantastic! I can clearly see how my
                        vocabulary is growing over time."</p>
                    <div class="text-sm text-gray-400">1 month of learning</div>
                </div>

                <div class="testimonial-card fade-in">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover mr-4"
                            src="{{ asset('assets/image/testimonials/user1.jpg') }}" alt="Emma Rodriguez">
                        <div>
                            <h4 class="font-semibold text-gray-800">Emma Rodriguez</h4>
                            <div class="flex mt-1">
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                                <span class="material-icons-round text-yellow-400">star</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Regular tests and reviews keep me motivated. I've learned more words
                        in a month than I did in a year of traditional study."</p>
                    <div class="text-sm text-gray-400">3 months of learning</div>
                </div>
            </div>

            {{-- Testimonial submission form for authenticated users --}}
            @auth
                <div class="submit-section rounded-xl shadow-md overflow-hidden">
                    <div class="md:flex">
                        <div
                            class="md:w-1/3 bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white flex flex-col justify-center">
                            <div class="text-center md:text-left">
                                <h3 class="text-2xl font-bold mb-3 text-white">Share Your Experience</h3>
                                <p class="text-white">Help other learners by sharing your learning
                                    journey with
                                    LexiLift.</p>
                                <div class="mt-6 flex justify-center md:justify-start">
                                    <div class="flex items-center justify-center bg-white bg-opacity-20 rounded-full p-3">
                                        <span
                                            class="material-symbols-outlined text-2xl text-[var(--accent-clr)]">chat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-2/3 bg-white p-8">
                            <form wire:submit.prevent="submitTestimonial">
                                <div class="mb-6">
                                    <label class="block text-gray-700 font-medium mb-2">Your Rating</label>
                                    <div class="flex space-x-1">
                                        <span
                                            class="material-icons-round text-2xl text-gray-300 cursor-pointer rating-input hover:text-yellow-400"
                                            data-rating="1">star</span>
                                        <span
                                            class="material-icons-round text-2xl text-gray-300 cursor-pointer rating-input hover:text-yellow-400"
                                            data-rating="2">star</span>
                                        <span
                                            class="material-icons-round text-2xl text-gray-300 cursor-pointer rating-input hover:text-yellow-400"
                                            data-rating="3">star</span>
                                        <span
                                            class="material-icons-round text-2xl text-gray-300 cursor-pointer rating-input hover:text-yellow-400"
                                            data-rating="4">star</span>
                                        <span
                                            class="material-icons-round text-2xl text-gray-300 cursor-pointer rating-input hover:text-yellow-400"
                                            data-rating="5">star</span>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-gray-700 font-medium mb-2" for="review">Your Review</label>
                                    <textarea wire:model="review" id="review" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                                        placeholder="Share your learning experience..."></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    {{-- Call to Action: Final conversion section --}}
    <div class="cta-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-4">Ready to Expand Your Vocabulary?</h2>
            <p class="mb-8 text-lg opacity-90">Join our community of learners and start your journey today</p>
            <a href="{{ route('register') }}" class="cta-button">
                Get Started Free
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
    </div>
</div>
