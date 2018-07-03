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
$address  = get_post_meta( get_the_ID(), 'otf_team_address', true );
$phone  = get_post_meta( get_the_ID(), 'otf_team_phone_number', true );
$email = get_post_meta( get_the_ID(), 'otf_team_email', true );
$web   = get_post_meta( get_the_ID(), 'otf_team_website', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    if (is_sticky() && is_home()) :
        echo ezboozt_get_svg( array( 'icon' => 'thumb-tack' ) );
    endif;
    ?>
    <div class="row">
        <div class="col-sm-4">
            <?php if ('' !== get_the_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>
            <div class="social">
                <?php OTF_Custom_Post_Type_Team::getInstance()->show_social(get_the_ID()); ?>
            </div>
        </div>
        <div class="col-sm-8">
            <header class="entry-header">
                <?php
                if ('post' === get_post_type()) {
                    echo '<div class="entry-meta">';
                    if (is_single()) {
                        ezboozt_posted_on();
                    } else {
                        echo ezboozt_time_link();
                        ezboozt_edit_link();
                    };
                    echo '</div><!-- .entry-meta -->';
                };

                if (is_single()) {
                    the_title( '<h1 class="team-title">', '</h1>' );
                } elseif (is_front_page() && is_home()) {
                    the_title( '<h3 class="team-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                } else {
                    the_title( '<h2 class="team-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                }
                ?>
            </header><!-- .entry-header -->
            <div class="entry-content">
                <?php
                /* translators: %s: Name of current post */
                the_content( sprintf(
                    __( 'Read more<span class="screen-reader-text"> "%s"</span>', 'ezboozt' ),
                    get_the_title()
                ) );

                wp_link_pages( array(
                    'before'      => '<div class="page-links">' . __( 'Pages:', 'ezboozt' ),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                ) );
                ?>
                <ul class="metabox list-unstyled">
                    <li>
                        <strong><?php esc_html_e('Address:', 'ezboozt')?></strong> <?php echo esc_html( $address ); ?>
                    </li>
                    <li>
                        <strong><?php esc_html_e('Phone:', 'ezboozt')?></strong> <?php echo esc_html( $phone ); ?>
                    </li>
                    <li>
                        <strong><?php esc_html_e('Web:', 'ezboozt')?></strong> <?php echo esc_html( $web ); ?>
                    </li>
                    <li>
                        <strong><?php esc_html_e('Email:', 'ezboozt')?></strong> <?php echo esc_html( $email ); ?>
                    </li>
                </ul>
            </div><!-- .entry-content -->
        </div>
    </div>

</article><!-- #post-## -->
