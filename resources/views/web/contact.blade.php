<x-layouts.web>
    <div class="relative">
        <img src="/static/group-photo.jpg" class="absolute inset-0 object-cover w-full h-full" alt="" />
        <div class="relative bg-opacity-75 bg-deep-purple-accent-700">
            <svg class="absolute inset-x-0 bottom-0 text-white" viewBox="0 0 1160 163">
                <path fill="currentColor"
                    d="M-164 13L-104 39.7C-44 66 76 120 196 141C316 162 436 152 556 119.7C676 88 796 34 916 13C1036 -8 1156 2 1216 7.7L1276 13V162.5H1216C1156 162.5 1036 162.5 916 162.5C796 162.5 676 162.5 556 162.5C436 162.5 316 162.5 196 162.5C76 162.5 -44 162.5 -104 162.5H-164V13Z">
                </path>
            </svg>
            <div
                class="relative px-4 py-16 mx-auto overflow-hidden sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                <div class="flex flex-col items-center justify-between xl:flex-row">
                    <div class="w-full max-w-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12">
                        <h2
                            class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
                            Contact Aowa Homes <br class="hidden md:block" />
                            For Your Dream Property
                        </h2>
                        <p class="max-w-xl mb-4 text-base text-gray-200 md:text-lg">
                            Get in touch with us for inquiries about our premium properties, real estate services, or
                            any questions you may have. We're here to help you find your perfect home.
                        </p>
                        <a href="/" aria-label=""
                            class="inline-flex items-center font-semibold tracking-wider transition-colors duration-200 text-teal-accent-400 hover:text-teal-accent-700">
                            View Our Properties
                            <svg class="inline-block w-3 ml-2" fill="currentColor" viewBox="0 0 12 12">
                                <path
                                    d="M9.707,5.293l-5-5A1,1,0,0,0,3.293,1.707L7.586,6,3.293,10.293a1,1,0,1,0,1.414,1.414l5-5A1,1,0,0,0,9.707,5.293Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div class="w-full max-w-xl xl:px-8 xl:w-5/12">
                        <div class="bg-white rounded shadow-2xl p-7 sm:p-10">
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                    role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h3 class="mb-4 text-xl font-semibold sm:text-center sm:mb-6 sm:text-2xl">
                                Contact Us
                            </h3>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="mb-1 sm:mb-2">
                                    <label for="fullName" class="inline-block mb-1 font-medium">Full Name</label>
                                    <input placeholder="Enter your full name" required="" type="text"
                                        class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                        id="fullName" name="fullName" />
                                </div>
                                <div class="mb-1 sm:mb-2">
                                    <label for="email" class="inline-block mb-1 font-medium">E-mail</label>
                                    <input placeholder="Enter your email" required="" type="email"
                                        class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                        id="email" name="email" />
                                </div>
                                <div class="mb-1 sm:mb-2">
                                    <label for="phone" class="inline-block mb-1 font-medium">Phone Number</label>
                                    <input placeholder="Enter your phone number" required="" type="tel"
                                        class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                        id="phone" name="phone" />
                                </div>
                                <div class="mb-1 sm:mb-2">
                                    <label for="message" class="inline-block mb-1 font-medium">Message</label>
                                    <textarea placeholder="How can we help you?" required=""
                                        class="flex-grow w-full h-32 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                        id="message" name="message"></textarea>
                                </div>
                                <div class="mt-4 mb-2 sm:mb-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-full h-12 px-6 font-medium tracking-wide text-black transition duration-300 rounded-full bg-[#FFF114] hover:bg-yellow-300 focus:shadow-outline focus:outline-none">
                                        Send Message
                                    </button>
                                </div>
                                <p class="text-xs text-gray-600 sm:text-sm">
                                    Your information is secure and will not be shared with third parties.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.web>
