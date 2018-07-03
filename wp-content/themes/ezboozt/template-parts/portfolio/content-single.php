<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

$data = array(
    'fullname'      => __('Author FullName', 'ezboozt'),
    'showcase_link' => __('Showcase Link', 'ezboozt'),
    'client'        => __('Client', 'ezboozt'),
    'date_created'  => __('Date Created', 'ezboozt'),
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php the_title( '<h2 class="entry-title">','</h2>' ); ?>
    </header><!-- .entry-header -->

    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'full' ); ?>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->

    <div class="information">
        <h4><?php esc_html_e( 'Information', 'ezboozt' ); ?></h4>
        <ul>
            <?php foreach($data as $key => $value): ?>
                <li class="<?php echo esc_attr($key); ?>">
                    <span class="meta-label"><?php echo trim( $value ); ?> : </span>
                    <?php echo get_post_meta(get_the_ID(), 'otf_portfolio_'.$key,true); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</article><!-- #post-## -->