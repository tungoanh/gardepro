<?php
/**
 * Template part for displaying image posts
 *
 * @link       https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    WordPress
 * @subpackage Twenty_Seventeen
 * @since      1.0
 * @version    1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-inner">
        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php if (!is_single()){ ?>
                <a href="<?php the_permalink(); ?>">
                    <?php } ?>

                    <?php the_post_thumbnail('ezboozt-featured-image'); ?>
                    <?php if (!is_single()){ ?>
                </a>
            <?php } ?>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>

        <header class="entry-header">
            <?php
            the_category('');
            if ('post' === get_post_type()) {
                echo '<div class="entry-meta">';
                if (is_single()) {
                    ezboozt_posted_on();
                } else {
                    ezboozt_posted_on();
                    ezboozt_edit_link();
                };
                echo '</div><!-- .entry-meta -->';
            };

            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } elseif (is_front_page() && is_home()) {
                the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
            } else {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            }
            ?>
        </header><!-- .entry-header -->

        <div class="entry-content">

            <?php
            // Only show content if is a single post, or if there's no featured image.
            /* translators: %s: Name of current post */
            the_content(sprintf(
                __('Read more<span class="screen-reader-text"> "%s"</span>', 'ezboozt'),
                get_the_title()
            ));

            if (is_single() || '' === get_the_post_thumbnail()) {
                wp_link_pages(array(
                    'before'      => '<div class="page-links">' . __('Pages:', 'ezboozt'),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                ));

            };
            ?>

        </div><!-- .entry-content -->

        <?php
        if (is_single()) {
            ezboozt_entry_footer();
        }
        ?>
    </div>

</article><!-- #post-## -->
