<!-- Modal -->
<div x-data="{ isviOpen: false }" @keydown.escape="isviOpen = false">
    <!-- Existing Hero Section -->
    <div class="relative flex flex-col py-16 lg:pt-0 lg:flex-col lg:pb-0">
        <div class="flex flex-col items-start w-full max-w-xl px-4 mx-auto lg:px-8 lg:max-w-screen-xl">
            <div class="mb-16 lg:my-40 lg:max-w-lg lg:pr-5">
                <div class="max-w-xl mb-6">
                    <div>
                        <p
                            class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-black uppercase rounded-full bg-[#FFF114]">
                            Welcome to AHOWA HOMES
                        </p>
                    </div>
                    <h2
                        class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none">
                        Your Dream Home<br class="hidden md:block" />
                        Awaits With
                        <span class="inline-block text-black">AHOWA HOMES</span>
                    </h2>
                    <p class="text-base text-gray-700 md:text-lg">
                        We develop, manage, and consult in real estate, helping you find your perfect home. Join us in
                        our
                        mission to create opportunities through real estate investment and stunning interior design
                        solutions.
                    </p>
                </div>
                <div class="flex flex-col items-center md:flex-row">
                    <a href="/properties"
                        class="inline-flex items-center justify-center w-full h-12 px-6 mb-3 font-medium tracking-wide text-white transition duration-200 rounded shadow-md md:w-auto md:mr-4 md:mb-0 bg-black hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                        View Properties
                    </a>
                    <a href="/contact" aria-label="Contact Us"
                        class="inline-flex items-center font-semibold text-black transition-colors duration-200 hover:text-gray-800">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

        <div
            class="inset-y-0 right-0 w-full max-w-xl px-4 mx-auto lg:pl-8 lg:pr-0 lg:mb-0 lg:mx-0 lg:w-1/2 lg:max-w-full lg:absolute xl:px-0">
            <!-- Mobile play button -->
            <div class="absolute  inset-0 flex lg:hidden items-center justify-center pointer-events-none z-10 mt-90">
                <div x-data="{ showTooltip: true }" class="relative">
                    <div x-show="showTooltip"
                        class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-[#FFF114] px-2 py-1 rounded-lg shadow-lg text-xs text-black whitespace-nowrap">
                        <button @click="showTooltip = false"
                            class="absolute -top-1 -right-1 bg-gray-200 rounded-full p-0.5">
                            <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z">
                                </path>
                            </svg>
                        </button>
                        Learn About Us
                        <div
                            class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-[#FFF114] rotate-45">
                        </div>
                    </div>
                    <button @click="isviOpen = true"
                        class=" cursor-pointer p-3 rounded-full bg-[#FFF114] relative group ">
                        <div
                            class="absolute inset-0 rounded-full bg-[#FFF114] opacity-75 animate-ping group-hover:opacity-50">
                        </div>
                        <div
                            class="absolute inset-0 rounded-full bg-[#FFF114] opacity-50 animate-pulse group-hover:scale-125 transition-transform duration-300">
                        </div>
                        <svg class="w-8 h-8 text-black relative z-10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <img class="object-cover w-full h-56 rounded shadow-lg lg:rounded-none lg:shadow-none sm:h-96 lg:h-full "
                src="/static/team-3.jpg" alt="" />

            <!-- Desktop play button -->
            <div class="absolute inset-0 hidden lg:flex items-center justify-center z-10 cursor-pointer">
                <div x-data="{ showTooltip: true }" class="relative">
                    <div x-show="showTooltip"
                        class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-[#FFF114] px-3 py-1 rounded-lg shadow-lg text-xs text-black whitespace-nowrap">
                        <button @click="showTooltip = false"
                            class="absolute -top-1 -right-1 bg-gray-200 rounded-full p-0.5">
                            <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z">
                                </path>
                            </svg>
                        </button>
                        Learn About Us
                        <div
                            class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-[#FFF114] rotate-45">
                        </div>
                    </div>
                    <button @click="isviOpen = true"
                        class="p-4 rounded-full bg-[#FFF114] relative group  cursor-pointer">
                        <div
                            class="absolute inset-0 rounded-full bg-[#FFF114] opacity-75 animate-ping group-hover:opacity-50">
                        </div>
                        <div
                            class="absolute inset-0 rounded-full bg-[#FFF114] opacity-50 animate-pulse group-hover:scale-125 transition-transform duration-300">
                        </div>
                        <svg class="w-12 h-12 text-black relative z-10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div x-cloak x-show="isviOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
        <div class="relative w-full max-w-4xl mx-4">
            <button @click="isviOpen = false" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="relative" style="padding-bottom: 56.25%;">
                <video x-show="isviOpen" class="absolute inset-0 w-full h-full" controls>
                    <source src="/static/about-video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
