<div class="bg-black py-8 border-y-2 border-[#FFF114]">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <!-- Title Section -->
            <div class="w-full md:w-1/4 pr-8 mb-6 md:mb-0">
                <h2 class="text-[#FFF114] text-3xl font-bold">Featured Updates</h2>
            </div>

            <!-- Poster Section -->
            <div class="w-full md:w-3/4 relative">
                <div class="flex items-center">
                    <!-- Left Button -->
                    <button
                        class="absolute cursor-pointer left-0 z-10 bg-[#FFF114]/80 p-2 rounded-full hover:bg-[#FFF114] transition-colors"
                        onclick="slideLeft()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Poster Container -->
                    <div class="overflow-hidden mx-8">
                        <div class="flex space-x-4 transition-all duration-300 ease-in-out" id="posterContainer">
                            @foreach($bannerImages as $image)
                                <div class="flex-none w-80 relative group">
                                    <img src="{{ asset('/storage/' . $image) }}" alt="Ahowa Homes Poster"
                                        class="w-full h-96 object-cover rounded-lg shadow-lg">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-end">
                                        <div class="p-4 text-white">
                                            <h3 class="text-[#FFF114] font-semibold">Advertisement</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Button -->
                    <button
                        class="absolute cursor-pointer right-0 z-10 bg-[#FFF114]/80 p-2 rounded-full hover:bg-[#FFF114] transition-colors"
                        onclick="slideRight()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('posterContainer');
        const slideAmount = 320; // Adjusted for new poster width

        function slideRight() {
            container.style.transform = `translateX(-${slideAmount}px)`;
            setTimeout(() => {
                container.appendChild(container.firstElementChild);
                container.style.transform = 'translateX(0)';
            }, 300);
        }

        function slideLeft() {
            container.insertBefore(container.lastElementChild, container.firstElementChild);
            container.style.transform = `translateX(-${slideAmount}px)`;
            requestAnimationFrame(() => {
                container.style.transition = 'transform 0.3s ease-in-out';
                container.style.transform = 'translateX(0)';
            });
        }

        // Reset transition after slide
        container.addEventListener('transitionend', () => {
            container.style.transition = 'none';
        });
    </script>
</div>
