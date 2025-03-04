<?php get_header(); ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
            <div class="aspect-w-16 aspect-h-9">
                <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
            </div>
        <?php endif; ?>

        <div class="p-6 md:p-8">
            <!-- Course Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                <?php the_title(); ?>
            </h1>

            <!-- Course Meta -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6">
                <span class="flex items-center">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <?php echo get_the_date(); ?>
                </span>
                <span class="flex items-center">
                    <i class="far fa-clock mr-2"></i>
                    <?php echo get_post_meta(get_the_ID(), 'course_duration', true) ?: '2 uur'; ?>
                </span>
                <span class="flex items-center">
                    <i class="far fa-user mr-2"></i>
                    <?php echo get_the_author(); ?>
                </span>
            </div>

            <!-- Course Content -->
            <div class="prose max-w-none course-content">
                <?php the_content(); ?>
            </div>

            <!-- Course Navigation -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>

                    <?php if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" 
                           class="inline-flex items-center text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Vorige Les
                        </a>
                    <?php endif; ?>

                    <?php if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>" 
                           class="inline-flex items-center text-emerald-600 hover:text-emerald-700">
                            Volgende Les
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <?php if (comments_open() || get_comments_number()) : ?>
        <div class="mt-8">
            <?php comments_template(); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
