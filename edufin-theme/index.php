<?php get_header(); ?>

<div class="max-w-7xl mx-auto">
    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-lg shadow-sm overflow-hidden card-hover">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-emerald-600">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <div class="text-gray-600 mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span>
                                <i class="far fa-comment mr-1"></i>
                                <?php comments_number('0', '1', '%'); ?> reacties
                            </span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<i class="fas fa-chevron-left mr-1"></i> Vorige',
                'next_text' => 'Volgende <i class="fas fa-chevron-right ml-1"></i>'
            ));
            ?>
        </div>

    <?php else : ?>
        <div class="text-center py-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Geen berichten gevonden</h2>
            <p class="text-gray-600">Er zijn momenteel geen berichten om weer te geven.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
