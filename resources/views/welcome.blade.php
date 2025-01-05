<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Other head elements -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .rounded-lg {
            border-radius: 0.75rem;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .hero {
            background-image: url('/path/to/your/background-image.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .btn-animated {
            transition: transform 0.3s ease;
        }
        .btn-animated:hover {
            transform: scale(1.05);
        }

        .divider {
            width: 100%;
            height: 1px;
            background-color: black; /* Tailwind's gray-200 color */
            margin: 2rem 0; /* Add some margin for spacing */
        }

        .feature-item {
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }
        .feature-item.show {
            opacity: 1;
        }
    </style>
</head>
<body>
    <x-guest-layout>
        <div class="hero flex flex-col items-center justify-center text-center text-white">
            <div x-data="{ open: false, text: false }" x-init="setTimeout(() => open = true, 500); setTimeout(() => text = true, 1000)" class="flex items-center justify-center mt-[-10%] flex-col" style="height: 300px;">
                <div x-show="text" x-transition.duration.5000ms class="mb-14 font-bold">
                    <h1 class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-black via-gray-400 to-black" style="font-family: 'Pacifico', cursive;">
                        FlashSmart
                    </h1>
                    <p class="text-xl text-black  mt-4 font-bold" style="font-family: 'Roboto', sans-serif;">
                        Click
                    </p>
                </div>
                <img x-show="open" x-transition.duration.4000ms class="w-56 h-56 mb-8 rounded-lg" src="{{ asset('images/flash-card.png') }}" alt="Flash Card Logo">
            </div>
            <div class="mt-5" x-data="{ open: false }" x-init="setTimeout(() => open = true, 1000)">
                <a x-show="open" x-transition.duration.1000ms href="{{ route('login') }}">
                    <x-mary-button class="btn-dark rounded-lg text-lg shadow-2xl w-56 mt-12 btn-animated" label="Get Started" style="color: #fe7d97;">
                    </x-mary-button>
                </a>
            </div>
        </div>
        <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="flex justify-between items-center py-10">
                <div class="flex justify-center">
                    <svg class="h-12 w-auto text-black lg:h-16 lg:text-[#FF2D20]" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- SVG content -->
                    </svg>
                </div>
                @if (Route::has('login'))
                    <nav class="absolute top-0 right-0 mt-4 mr-4 flex space-x-4">
                        @auth
                            @if (Auth::check() && Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full">
                            @endif
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-3 py-2 text-black hover:text-gray-700">
                                    Register
                                </a>
                            @endif
                        @endauth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white">
                            Dashboard
                        </a>
                    </nav>
                @endif
            </header>
        </div>
        <div x-data="{ showFeatures: false }" x-init="window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                showFeatures = true;
            }
        })">
            <div class="features py-12">
                <div class="container mx-auto text-center">
                    <div class="flex justify-center items-center">
                        <x-mary-header class="text-black" title="Features"/>
                        <div class="divider"></div>
                    </div>
                    <div class="flex justify-around">
                        <div class="feature-item" :class="{ 'show': showFeatures }" x-transition.enter.duration.5000ms.opacity.25>
                            <img src="{{ asset('images/undraw_undraw_undraw_undraw_smartphone_34c3_-1-_orrt_-1-_tyrp_-1-_fl8c.svg') }}" alt="Feature 1" class="w-72 h-72 mx-auto mb-4">
                            <h3 class="text-xl font-semibold">Mobile Friendly📲</h3>
                        </div>
                        <div class="feature-item" :class="{ 'show': showFeatures }" x-transition.enter.duration.8000ms.opacity.25>
                            <img src="{{ asset('images/undraw_undraw_posts_1aht_-3-_1pfi_-1-_n75o_-1-_lsbs.svg') }}" alt="Feature 2" class="w-72 h-72 mx-auto mb-4">
                            <h3 class="text-xl font-semibold">Feature 2</h3>
                            <p class="text-gray-600">Description of feature 2.</p>
                        </div>
                        <div class="feature-item" :class="{ 'show': showFeatures }" x-transition.enter.duration.10000ms.opacity.25>
                            <img src="{{ asset('images/undraw_undraw_landing_new_pboa_-2-_nm82.svg') }}" alt="Feature 3" class="w-72 h-72 mx-auto mb-4">
                            <h3 class="text-xl font-semibold">Feature 3</h3>
                            <p class="text-gray-600">Description of feature 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonials py-12 bg-gray-100">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold mb-8">Testimonials</h2>
                <div class="flex justify-around">
                    <div class="testimonial-item">
                        <p class="text-gray-600">"This app is amazing! It has helped me so much."</p>
                        <p class="text-black font-semibold mt-4">- User 1</p>
                    </div>
                    <div class="testimonial-item">
                        <p class="text-gray-600">"I love using this app every day. Highly recommend!"</p>
                        <p class="text-black font-semibold mt-4">- User 2</p>
                    </div>
                    <div class="testimonial-item">
                        <p class="text-gray-600">"A must-have app for anyone looking to improve."</p>
                        <p class="text-black font-semibold mt-4">- User 3</p>
                    </div>
                </div>
            </div>
        </div>
        <footer class="py-6 bg-gray-800 text-white">
            <div class="container mx-auto text-center">
                <p>&copy; 2024 FlashSmart. All rights reserved.</p>
                <div class="flex justify-center space-x-4 mt-4">
                    <a href="#" class="text-white hover:text-gray-400">Privacy Policy</a>
                    <a href="#" class="text-white hover:text-gray-400">Terms of Service</a>
                    <a href="mailto:jacksongrove.dev@gmail.com">Contact Us</a>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </footer>
    </x-guest-layout>
</body>
</html>
