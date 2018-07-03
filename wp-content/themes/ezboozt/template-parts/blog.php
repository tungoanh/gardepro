<?php
/* Start the Loop */
if(get_theme_mod('otf_blog_archive_style',1) == 1) {
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part( 'template-parts/post/content', get_post_format() );

    endwhile;
}else {
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part( 'template-parts/post/content', 'style-4' );

    endwhile;
}