</main>
    </div>
</div>

<footer class="bg-white border-t mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Over Edufin</h3>
                <p class="text-gray-600">
                    Leer alles over persoonlijke financiën, investeringen en ondernemerschap. 
                    Groei samen met onze community.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Snelle Links</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'space-y-2',
                    'fallback_cb' => false
                ));
                ?>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                <div class="space-y-2 text-gray-600">
                    <p><i class="fas fa-envelope mr-2"></i> info@edufin.com</p>
                    <p><i class="fas fa-phone mr-2"></i> +31 (0)6 12345678</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-emerald-600">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-600">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t mt-8 pt-8 text-center text-gray-500">
            <p>&copy; <?php echo date('Y'); ?> Edufin. Alle rechten voorbehouden.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
