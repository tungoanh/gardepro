<?php
if (has_post_thumbnail()){
    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'ezboozt-featured-image' );
} else{
    $thumbnail_url = ezboozt_get_placeholder_image();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'column-item col-auto' ); ?>>
    <div class="inner d-flex flex-column">
        <header class="entry-header">
            <div class="meta">
                <?php
                echo '<div class="entry-meta">';
                echo ezboozt_time_link();
                echo '</div><!-- .entry-meta -->';
                the_category( '' );
                the_title( '<h3 class="heading"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
            </div>
        </header><!-- .entry-header -->

        <div class="post-thumbnail" style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>)">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( get_the_title() ) ?>" class="d-none">
            </a>
        </div><!-- .post-thumbnail -->
        <div class="description">
            <?php echo ezboozt_get_excerpt(15); ?>
        </div>

    </div>
</article><!-- #post-## -->
