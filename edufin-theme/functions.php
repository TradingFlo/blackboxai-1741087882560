<?php
/**
 * Theme functions and definitions
 */

// Add theme support
function edufin_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('menus');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'edufin'),
        'sidebar' => __('Sidebar Menu', 'edufin')
    ));
}
add_action('after_setup_theme', 'edufin_theme_setup');

// Enqueue scripts and styles
function edufin_scripts() {
    // Tailwind CSS - Add script tag directly in header
    add_action('wp_head', function() {
        echo '<script src="https://cdn.tailwindcss.com"></script>';
        echo '<script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            emerald: {
                                50: "#ecfdf5",
                                100: "#d1fae5",
                                200: "#a7f3d0",
                                300: "#6ee7b7",
                                400: "#34d399",
                                500: "#10b981",
                                600: "#059669",
                                700: "#047857",
                                800: "#065f46",
                                900: "#064e3b"
                            }
                        }
                    }
                }
            }
        </script>';
    });
    
    // Custom styles
    wp_enqueue_style('edufin-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0');
    
    // Custom JavaScript
    wp_enqueue_script('edufin-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/main.js'), true);
    
    // Localize script for AJAX
    wp_localize_script('edufin-script', 'edufin_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'edufin_scripts');

// Add content protection
function edufin_protect_content() {
    if (is_singular('course')) {
        // Disable right click
        wp_add_inline_script('edufin-script', '
            document.addEventListener("contextmenu", function(e) {
                if (e.target.closest(".course-content")) {
                    e.preventDefault();
                }
            });
            
            // Disable text selection
            document.addEventListener("selectstart", function(e) {
                if (e.target.closest(".course-content")) {
                    e.preventDefault();
                }
            });
            
            // Disable copy
            document.addEventListener("copy", function(e) {
                if (e.target.closest(".course-content")) {
                    e.preventDefault();
                }
            });
            
            // Disable view source keyboard shortcuts
            document.addEventListener("keydown", function(e) {
                if ((e.ctrlKey || e.metaKey) && (
                    e.key === "s" || 
                    e.key === "u" ||
                    e.key === "p" ||
                    e.key === "a"
                )) {
                    if (e.target.closest(".course-content")) {
                        e.preventDefault();
                    }
                }
            });
        ');

        // Add content protection headers
        add_action("template_redirect", function() {
            header("X-Frame-Options: DENY");
            header("X-Content-Type-Options: nosniff");
            header("X-XSS-Protection: 1; mode=block");
        });
    }
}
add_action("wp_enqueue_scripts", "edufin_protect_content");

// Obfuscate course content in HTML
function edufin_obfuscate_content($content) {
    if (is_singular("course") && !is_admin()) {
        // Convert content to base64
        $encoded = base64_encode($content);
        
        // Return encoded content with decoder
        return sprintf(
            '<div class="course-content" data-content="%s"></div>
            <script>
                (function() {
                    var content = document.querySelector(".course-content");
                    if (content) {
                        content.innerHTML = atob(content.dataset.content);
                        content.dataset.content = "";
                    }
                })();
            </script>',
            $encoded
        );
    }
    return $content;
}
add_filter("the_content", "edufin_obfuscate_content", 999);

// Add TinyMCE buttons for course conversations
function edufin_add_mce_buttons() {
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    
    if ('true' == get_user_option('rich_editing')) {
        add_filter('mce_external_plugins', 'edufin_add_mce_plugin');
        add_filter('mce_buttons', 'edufin_register_mce_buttons');
    }
}
add_action('admin_init', 'edufin_add_mce_buttons');

function edufin_add_mce_plugin($plugin_array) {
    $plugin_array['edufin_mce_button'] = get_template_directory_uri() . '/assets/js/tinymce-plugin.js';
    return $plugin_array;
}

function edufin_register_mce_buttons($buttons) {
    array_push($buttons, 'teacher_message', 'student_message');
    return $buttons;
}

// Include admin pages
require_once get_template_directory() . '/admin/announcements.php';

// Create required database tables on theme activation
function edufin_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Courses progress table
    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}user_courses (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        course_id bigint(20) NOT NULL,
        progress int(3) NOT NULL DEFAULT 0,
        enrolled_at datetime DEFAULT CURRENT_TIMESTAMP,
        completed_at datetime DEFAULT NULL,
        PRIMARY KEY  (id),
        KEY user_id (user_id),
        KEY course_id (course_id)
    ) $charset_collate;";

    // Announcements table
    $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}announcements (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        message text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        status varchar(20) DEFAULT 'active',
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'edufin_create_tables');
