<div class="w-100 d-flex justify-content-between flex-wrap">
    <div class="d-flex align-items-center topbar-left">
        <?php if (has_nav_menu( 'social' ) && get_theme_mod( 'otf_header_topbar_is_menu_left', true )) : ?>
            <nav class="social-navigation" role="navigation"
                 aria-label="<?php esc_attr_e( 'Topbar Social Links Menu', 'ezboozt' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'social',
                    'menu_class'     => 'social-links-menu',
                    'depth'          => 1,
                    'link_before'    => '<span class="screen-reader-text">',
                    'link_after'     => '</span><i class="fa fa-link" aria-hidden="true"></i>',
                ) );
                ?>
            </nav><!-- .social-navigation -->
        <?php endif; ?>
    </div>
</div>
