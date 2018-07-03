<?php
$title_class = ezboozt_get_metabox( get_the_ID(), 'otf_enable_page_heading', true) ? '' : ' screen-reader-text';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title' . esc_attr($title_class) . '">', '</h1>' ); ?>
        <?php ezboozt_edit_link( get_the_ID() ); ?>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'ezboozt' ),
            'after'  => '</div>',
        ) );

        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
