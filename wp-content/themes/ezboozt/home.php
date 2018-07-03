<?php

get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php
                if (have_posts()) :
                    get_template_part('template-parts/blog');
                    the_posts_pagination( array(
                        'prev_text'          => '<span class="fa fa-arrow-left"></span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'ezboozt' ) . '</span>',
                        'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'ezboozt' ) . '</span><span class="fa fa-arrow-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'ezboozt' ) . ' </span>',
                    ) );
                else :
                    get_template_part( 'template-parts/post/content', 'none' );

                endif;
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();