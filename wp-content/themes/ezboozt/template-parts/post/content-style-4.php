<?php
if (has_post_thumbnail()) {
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'ezboozt-featured-image');
} else {
    $thumbnail_url = ezboozt_get_placeholder_image();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('otf-post-style'); ?>>
    <div class="post-inner">
        <div class="post-thumbnail embed-responsive embed-responsive-16by9"
             style="background-image: url(<?php echo esc_url($thumbnail_url); ?>)">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()) ?>"
                     class="d-none">
            </a>
        </div><!-- .post-thumbnail -->
        <header class="entry-header">
            <?php
            if ('post' === get_post_type()) {
                echo '<div class="entry-meta">';
                ezboozt_posted_on();
                echo '</div><!-- .entry-meta -->';
            }
            the_category('');
            the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
        </header><!-- .entry-header -->
        <div class="description entry-content">
            <?php
            echo ezboozt_get_excerpt(25); ?>
        </div>
    </div>
</article><!-- #post-## -->
