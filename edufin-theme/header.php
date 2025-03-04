<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-50'); ?>>

<!-- Mobile Menu Button (visible only on mobile) -->
<button id="mobile-menu-button" 
        class="lg:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
    <i class="fas fa-bars text-xl text-emerald-600"></i>
    <span class="sr-only">Menu openen</span>
</button>

<div class="flex min-h-screen">
    <!-- Left Sidebar -->
    <aside class="w-64 bg-white shadow-lg fixed h-full transform lg:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out z-40">
        <!-- Logo -->
        <div class="px-6 py-4">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <h1 class="text-2xl font-bold text-emerald-600">Edufin</h1>
            <?php endif; ?>
        </div>

        <!-- Search Bar -->
        <div class="px-4 mb-4">
            <div class="relative">
                <input type="text" 
                       id="live-search" 
                       class="w-full px-4 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                       placeholder="Zoeken...">
                <div id="search-results" class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg hidden"></div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="px-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'sidebar',
                'container' => false,
                'menu_class' => 'space-y-2',
                'fallback_cb' => false
            ));
            ?>
        </nav>

        <!-- Login/Register Section (visible only when logged out) -->
        <?php if (!is_user_logged_in()): ?>
            <div class="mt-auto px-4 py-6 border-t">
                <a href="<?php echo wp_login_url(); ?>" 
                   class="block w-full mb-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-center hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="<?php echo wp_registration_url(); ?>" 
                   class="block w-full px-4 py-2 bg-white text-emerald-600 border-2 border-emerald-600 rounded-lg text-center hover:bg-emerald-50 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </a>
            </div>
        <?php endif; ?>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 lg:ml-64 transition-all duration-300">
        <!-- Top Header -->
        <header class="bg-white shadow-sm">
            <div class="flex justify-between items-center px-4 lg:px-8 py-4">
                <!-- Announcements Banner -->
                <div class="flex-1 overflow-hidden relative h-10 hidden md:block">
                    <div class="bg-emerald-50 rounded-lg px-4 py-2">
                        <div class="announcement-scroll absolute whitespace-nowrap">
                            <?php
                            global $wpdb;
                            $announcements = $wpdb->get_results(
                                "SELECT title FROM {$wpdb->prefix}announcements WHERE status = 'active' ORDER BY created_at DESC LIMIT 5"
                            );
                            foreach ($announcements as $announcement) {
                                echo '<span class="inline-block mr-8"><i class="fas fa-bullhorn text-emerald-600 mr-2"></i>' . esc_html($announcement->title) . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Right Header Section -->
                <div class="flex items-center space-x-2 md:space-x-6">
                    <!-- Social Media Icons -->
                    <div class="hidden md:flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-emerald-600">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-emerald-600">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-emerald-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    <!-- Invite Friends Button -->
                    <button class="bg-emerald-500 text-white px-3 md:px-4 py-2 rounded-lg hover:bg-emerald-600 transition-colors flex items-center space-x-1 md:space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span class="hidden md:inline">Vrienden Uitnodigen</span>
                    </button>

                    <!-- User Menu -->
                    <?php if (is_user_logged_in()): ?>
                        <div class="relative">
                            <button class="flex items-center space-x-2">
                                <img src="<?php echo get_avatar_url(get_current_user_id()); ?>" 
                                     alt="Profile" 
                                     class="w-8 h-8 rounded-full">
                                <i class="fas fa-chevron-down text-sm text-gray-600"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="px-8 py-3 bg-emerald-50">
                <?php
                $total_users = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->users}");
                $target_users = 10000;
                $progress = ($total_users / $target_users) * 100;
                ?>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-gray-600">Community Groei</span>
                    <span class="text-sm text-gray-600"><?php echo $total_users; ?> van <?php echo $target_users; ?> gebruikers</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-emerald-600 h-2.5 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                </div>
            </div>
        </header>

        <!-- Main Content Container -->
        <main class="p-4 md:p-8">

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" 
     class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity duration-300">
</div>
