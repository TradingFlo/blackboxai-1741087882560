<?php get_header(); ?>

<!-- Hero Section -->
<div class="bg-emerald-50 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Begin Je Reis naar<br>
                    <span class="text-emerald-600">Financiële Vrijheid</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Ontdek de wereld van persoonlijke financiën, investeringen en ondernemerschap. 
                    Leer van experts en groei samen met onze community.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo get_post_type_archive_link('course'); ?>" 
                       class="btn-hover-effect inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Start met Leren
                    </a>
                    <a href="#" 
                       class="btn-hover-effect inline-flex items-center justify-center px-6 py-3 border-2 border-emerald-600 text-base font-medium rounded-lg text-emerald-600 bg-white hover:bg-emerald-50">
                        <i class="fas fa-user-plus mr-2"></i>
                        Nodig Vrienden Uit
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="<?php echo get_theme_file_uri('assets/images/hero-image.jpg'); ?>" 
                     alt="Financial Education" 
                     class="rounded-lg shadow-xl">
            </div>
        </div>
    </div>
</div>

<!-- Featured Courses -->
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Populaire Cursussen</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $featured_courses = new WP_Query(array(
                'post_type' => 'course',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            while ($featured_courses->have_posts()) : $featured_courses->the_post();
            ?>
                <article class="bg-white rounded-lg shadow-sm overflow-hidden card-hover">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-emerald-600">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <div class="text-gray-600 mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" 
                           class="inline-flex items-center text-emerald-600 hover:text-emerald-700">
                            Bekijk Cursus
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Waarom Edufin?</h2>
            <p class="text-xl text-gray-600">Ontdek waarom duizenden mensen kiezen voor onze leeromgeving</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Praktische Kennis</h3>
                <p class="text-gray-600">
                    Leer direct toepasbare financiële vaardigheden van ervaren professionals.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Actieve Community</h3>
                <p class="text-gray-600">
                    Deel ervaringen en leer van anderen in onze groeiende community.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Uitgebreide Content</h3>
                <p class="text-gray-600">
                    Van basis tot expert: ontdek nieuwe modules naarmate we groeien.
                </p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
