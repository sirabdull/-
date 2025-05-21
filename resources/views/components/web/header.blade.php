<div>
    <header x-data="{ isOpen: false }" class="text-white bg-black">
        <!-- Top Bar -->
        <div class="bg-[#FFF114] py-2 text-black">
            <div class="container flex items-center justify-between px-4 mx-auto text-sm font-light">
                <div class="flex items-center space-x-4">
                    <a href="tel:+1234567890" class="flex items-center hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{env('WATSAPP_NUMBER')}}
                    </a>
                    <a href="mailto:{{env('BUSINESS_EMAIL')}}" class="flex items-center hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{env('BUSINESS_EMAIL')}}
                    </a>
                </div>
            </div>
        </div>
        <!-- Main Navigation -->
        <nav class="container px-4 py-4 mx-auto">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="text-2xl font-light md:order-first order-2 md:ml-0 mx-auto">
                    <a href="/" class="flex items-center">
                        <img src="{{asset('static/logo.jpg')}}" class="h-12" alt="Digital Real Estate Platform"
                            srcset="">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="items-center hidden space-x-8 md:flex font-light">
                    <a href="/"
                        class="{{ request()->routeIs('home') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'hover:text-[#FFF114]' }}">Home</a>
                    <a href="/properties"
                        class="{{ request()->routeIs('properties') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'hover:text-[#FFF114]' }}">Property
                        Listings</a>

                    <a href="/locations"
                        class="{{ request()->routeIs('locations') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'hover:text-[#FFF114]' }}">Locations</a>

                    <a href="/blog"
                        class="{{ request()->routeIs('blog') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'hover:text-[#FFF114]' }}">Blogs</a>
                    <a href="/about"
                        class="{{ request()->routeIs('about') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'hover:text-[#FFF114]' }}">About
                        Us</a>
                    <a href="/contact"
                        class="{{ request()->routeIs('contact') ? 'bg-yellow-300' : 'bg-[#FFF114]' }} text-black px-6 py-2 rounded-full font-light hover:bg-yellow-300 transition duration-300">Contact
                        Us</a>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="isOpen = !isOpen"
                    class="text-white focus:outline-none order-1 md:hidden cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation Sidebar -->
            <div x-cloak style="z-index: 999" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-full" @click.away="isOpen = false"
                class="fixed inset-y-0 left-0 w-64 bg-black shadow-lg md:hidden">
                <!-- Close Button -->
                <button @click="isOpen = false" class="absolute top-4 right-4 text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="flex flex-col h-full pt-20 font-light">
                    <a href="/"
                        class="{{ request()->routeIs('home') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'text-white hover:text-[#FFF114]' }} px-6 py-3 border-b border-gray-800">Home</a>
                    <a href="/properties"
                        class="{{ request()->routeIs('properties') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'text-white hover:text-[#FFF114]' }} px-6 py-3 border-b border-gray-800">Property
                        Listings</a>
                    <a href="/locations"
                        class="{{ request()->routeIs('locations') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'text-white hover:text-[#FFF114]' }} px-6 py-3 border-b border-gray-800">Locations</a>

                    <a href="/blog"
                        class="{{ request()->routeIs('blog') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'text-white hover:text-[#FFF114]' }} px-6 py-3 border-b border-gray-800">Blogs</a>
                    <a href="/about"
                        class="{{ request()->routeIs('about') ? 'text-[#FFF114] border-b-2 border-[#FFF114]' : 'text-white hover:text-[#FFF114]' }} px-6 py-3 border-b border-gray-800">About
                        Us</a>
                    <a href="/contact"
                        class="{{ request()->routeIs('contact') ? 'bg-yellow-300' : 'bg-[#FFF114]' }} px-6 py-3 mt-4 mx-4 text-black text-center rounded-full hover:bg-yellow-300">Contact
                        Us</a>
                </div>
            </div>
        </nav>
    </header>
</div>
