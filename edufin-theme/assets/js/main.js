jQuery(document).ready(function($) {
    // Mobile Menu Toggle
    const mobileMenuButton = $('#mobile-menu-button');
    const sidebar = $('aside');
    const overlay = $('#mobile-menu-overlay');
    
    function toggleMobileMenu() {
        sidebar.toggleClass('-translate-x-full');
        overlay.toggleClass('hidden');
        $('body').toggleClass('overflow-hidden');
    }
    
    mobileMenuButton.on('click', toggleMobileMenu);
    overlay.on('click', toggleMobileMenu);

    // Live Search
    let searchTimeout;
    const searchInput = $('#live-search');
    const searchResults = $('#search-results');
    
    searchInput.on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val();
        
        if (query.length < 2) {
            searchResults.html('').addClass('hidden');
            return;
        }
        
        searchTimeout = setTimeout(function() {
            $.ajax({
                url: edufin_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'edufin_live_search',
                    search: query
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '<div class="py-2">';
                        response.data.forEach(function(item) {
                            const icon = item.type === 'course' ? 'graduation-cap' : 'file-alt';
                            html += `
                                <a href="${item.url}" class="block px-4 py-2 hover:bg-emerald-50">
                                    <div class="flex items-center">
                                        <i class="fas fa-${icon} text-emerald-600 mr-2"></i>
                                        <span>${item.title}</span>
                                    </div>
                                </a>
                            `;
                        });
                        html += '</div>';
                        searchResults.html(html).removeClass('hidden');
                    } else {
                        searchResults.html('<div class="px-4 py-2 text-gray-500">Geen resultaten gevonden</div>').removeClass('hidden');
                    }
                }
            });
        }, 300);
    });
    
    // Hide search results when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-container').length) {
            searchResults.addClass('hidden');
        }
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });

    // Initialize tooltips
    $('[data-tooltip]').each(function() {
        $(this).tooltip({
            title: $(this).data('tooltip'),
            placement: 'top',
            trigger: 'hover'
        });
    });

    // Handle course progress
    $('.mark-complete').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const courseId = button.data('course-id');
        
        $.ajax({
            url: edufin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'edufin_mark_complete',
                course_id: courseId
            },
            success: function(response) {
                if (response.success) {
                    button
                        .removeClass('bg-emerald-600 hover:bg-emerald-700')
                        .addClass('bg-gray-300')
                        .prop('disabled', true)
                        .html('<i class="fas fa-check mr-2"></i>Voltooid');
                }
            }
        });
    });

    // Announcement scroll pause on hover
    const announcement = $('.announcement-scroll');
    announcement.on('mouseenter', function() {
        $(this).css('animation-play-state', 'paused');
    }).on('mouseleave', function() {
        $(this).css('animation-play-state', 'running');
    });
});
