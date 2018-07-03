<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php if (get_theme_mod( 'otf_page_404_page_enable' ) != 'default' && !empty( get_theme_mod( 'otf_page_404_page_custom' ) )): ?>
                    <?php $query = new WP_Query( 'page_id=' . get_theme_mod( 'otf_page_404_page_custom' ) );
                    if ($query->have_posts()):
                        while ($query->have_posts()) : $query->the_post();
                            the_content();
                        endwhile;
                    endif; ?>
                <?php else: ?>
                    <section class="error-404 not-found">
                        <div class="page-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-12 m-auto text-center p-5">
                                        <h1 class="mb-0 mt-2"><?php esc_html_e( '404', 'ezboozt' ); ?></h1>
                                        <div class="error-title mb-2"><?php esc_html_e( 'Oops! that link is broken.', 'ezboozt' ); ?></div>
                                        <p class="px-5 pb-4"><?php echo esc_html_e( "Page does not exist or some other error occured. Go to our ", 'ezboozt' ) ?>
                                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home page', 'ezboozt' ); ?></a>
                                            <span><?php esc_html_e( 'or go back to', 'ezboozt' ); ?></span>
                                            <a href="javascript: history.go(-1)"><?php esc_html_e( 'Previous page', 'ezboozt' ); ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                <?php endif; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->

<?php get_footer();
