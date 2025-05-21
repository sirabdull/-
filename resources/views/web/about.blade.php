<x-layouts.web>

    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="lg:pr-5">
                <div class="max-w-xl mb-6">
                    <div>
                        <p
                            class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-black uppercase rounded-full bg-[#FFF114]">
                            Welcome to AHOWA EXCHANGE GLOBAL SERVICES LTD
                        </p>
                    </div>
                    <h2
                        class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-black sm:text-4xl sm:leading-none">
                        Real Estate Development<br class="hidden md:block" />
                        & Interior Design
                        <span class="inline-block text-[#FFF114]">Excellence</span>
                    </h2>
                    <p class="text-base text-gray-700 md:text-lg">
                        At AHOWA EXCHANGE GLOBAL SERVICES LTD, we're more than just real estate - we're your complete
                        property solution. We manage, develop, and consult for new investors entering the real estate
                        market. Our mission is twofold: delivering dream homes to our clients and creating
                        wealth-building opportunities through real estate sales. Through our AHOWA Homes division, we
                        also provide premium interior decor services, ensuring your new home is perfectly furnished with
                        designs that complement its architecture.
                    </p>
                </div>
                <div class="flex flex-col items-center md:flex-row">
                    <a href="/properties"
                        class="inline-flex items-center justify-center w-full h-12 px-6 mb-3 font-medium tracking-wide text-white transition duration-200 rounded-full shadow-md md:w-auto md:mr-4 md:mb-0 bg-black hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                        <span class="mr-3">View Properties</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="/contact" aria-label="Contact Us"
                        class="inline-flex items-center px-6 py-3 rounded-full border-2 border-black text-black hover:bg-black hover:text-[#FFF114] transition duration-300">
                        Contact Us
                    </a>
                </div>
            </div>
            <div class="relative">
                <video class="object-cover w-full h-56 rounded-lg shadow-lg sm:h-96" controls>
                    <source src="/static/about-video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-black py-16">
        <div class="container mx-auto px-4">
            <div class="relative bg-[#FFF114] rounded-2xl p-8 md:p-12 overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute -left-16 -top-16 w-48 h-48 rounded-full bg-black opacity-10 transform rotate-45">
                </div>
                <div
                    class="absolute -right-16 -bottom-16 w-48 h-48 rounded-full bg-black opacity-10 transform rotate-45">
                </div>

                <div class="relative z-10">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-black mb-4">Our Impact in Numbers</h2>
                        <p class="text-black/80 text-lg">The results of our dedication and commitment to excellence</p>
                    </div>

                    <div x-data="{
                        clients: 0,
                        properties: 0,
                        investments: 0,
                        satisfaction: 0,
                        init() {
                            setInterval(() => {
                                if(this.clients < 500) this.clients += 5;
                            }, 20);
                            setInterval(() => {
                                if(this.properties < 200) this.properties += 2;
                            }, 20);
                            setInterval(() => {
                                if(this.investments < 50) this.investments += 1;
                            }, 40);
                            setInterval(() => {
                                if(this.satisfaction < 98) this.satisfaction += 1;
                            }, 20);
                        }
                    }" x-init="init()" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- Stat Item 1 -->
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-black mb-2">
                                    <span x-text="clients">0</span>+
                                </div>
                                <p class="text-gray-700 font-medium">Clients Served</p>
                            </div>
                        </div>

                        <!-- Stat Item 2 -->
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-black mb-2">
                                    <span x-text="properties">0</span>+
                                </div>
                                <p class="text-gray-700 font-medium">Properties Managed</p>
                            </div>
                        </div>

                        <!-- Stat Item 3 -->
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-black mb-2">
                                    ₦<span x-text="investments">0</span>M+
                                </div>
                                <p class="text-gray-700 font-medium">In Investments</p>
                            </div>
                        </div>

                        <!-- Stat Item 4 -->
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-black mb-2">
                                    <span x-text="satisfaction">0</span>%
                                </div>
                                <p class="text-gray-700 font-medium">Client Satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->

    <x-web.team />
    <x-web.cta />
</x-layouts.web>
