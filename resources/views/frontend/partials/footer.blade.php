<footer class="bg-white border-t border-gray-200" id="contact">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

            <div class="md:col-span-1">
                {{-- Use your logo image if you have a light-bg version --}}
                <h3 class="text-2xl font-bold hero-text text-gray-800 mb-4">Tarangini Jewels</h3>
                <div class="space-y-3 text-gray-600">
                    <p class="flex items-center">
                        <x-heroicon-o-phone class="w-5 h-5 mr-3 flex-shrink-0" />
                        <span>+91 987 654 3210</span> {{-- Replace with your number --}}
                    </p>
                    <p class="flex items-center">
                        <x-heroicon-o-envelope class="w-5 h-5 mr-3 flex-shrink-0" />
                        <span>info@tarangini.com</span> {{-- Replace with your email --}}
                    </p>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold hero-text text-gray-800 mb-4">Shop</h4>
                <nav class="flex flex-col space-y-3">
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Rings</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Necklaces</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Earrings</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Bracelets</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Collections</a>
                </nav>
            </div>

            <div>
                <h4 class="text-lg font-semibold hero-text text-gray-800 mb-4">Quick Links</h4>
                <nav class="flex flex-col space-y-3">
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Privacy Policy</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Terms & Conditions</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Return & Refund</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Shipping Policy</a>
                    <a href="#" class="text-gray-600 hover:text-brand-gold transition">Contact Us</a>
                </nav>
            </div>

            <div>
                <h4 class="text-lg font-semibold hero-text text-gray-800 mb-4">Social Media</h4>
                <p class="text-gray-600 mb-4">Follow us for the latest collections and offers.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-brand-gold transition" aria-label="Instagram">
                        {{-- You'll need an SVG or icon for Instagram. I'll use Heroicons as a placeholder. --}}
                        <x-heroicon-o-camera class="w-7 h-7" />
                    </a>
                    <a href="#" class="text-gray-500 hover:text-brand-gold transition" aria-label="Facebook">
                        <x-heroicon-o-share class="w-7 h-7" /> {{-- Placeholder --}}
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-gray-100 py-4 border-t border-gray-200">
        <p class="text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} Tarangini Jewels. All Rights Reserved.
        </p>
    </div>
</footer>
