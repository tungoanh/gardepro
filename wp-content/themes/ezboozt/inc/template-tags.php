<?php
if (!function_exists( 'ezboozt_posted_on' )) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function ezboozt_posted_on() {

        // Get the author name; wrap it in a link.
        $byline = sprintf(
        /* translators: %s: post author */
            __( 'By %s', 'ezboozt' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
        );

        // Finally, let's write all of this to the page.
        echo '<span class="posted-on">' . ezboozt_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
    }
endif;


if (!function_exists( 'ezboozt_time_link' )) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function ezboozt_time_link() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time( 'U' ) !== get_the_modified_time( 'U' )){
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            get_the_date( DATE_W3C ),
            get_the_date(),
            get_the_modified_date( DATE_W3C ),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        return sprintf(
        /* translators: %s: post date */
            __( '<span class="posted_on">Posted on</span> %s', 'ezboozt' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );
    }
endif;


if (!function_exists( 'ezboozt_entry_footer' )) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function ezboozt_entry_footer() {

        /* translators: used between list items, there is a space after the comma */
        $separate_meta = __( ', ', 'ezboozt' );

        // Get Categories for posts.
        $categories_list = get_the_category_list( $separate_meta );

        // Get Tags for posts.
        $tags_list = get_the_tag_list( '', $separate_meta );

        // We don't want to output .entry-footer if it will be empty, so make sure its not.
        if (( ( ezboozt_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link()){

            echo '<footer class="entry-footer">';

            if ('post' === get_post_type()){
                if (( $categories_list && ezboozt_categorized_blog() ) || $tags_list){
                    echo '<span class="cat-tags-links">';

                    // Make sure there's more than one category before displaying.
                    if ($categories_list && ezboozt_categorized_blog()){
                        echo '<span class="cat-links"><i class="fa fa-folder-open"></i><span class="screen-reader-text">' . __( 'Categories', 'ezboozt' ) . '</span>' . $categories_list . '</span>';
                    }

                    if ($tags_list){
                        echo '<span class="tags-links"><i class="fa fa-hashtag"></i><span class="screen-reader-text">' . __( 'Tags', 'ezboozt' ) . '</span>' . $tags_list . '</span>';
                    }

                    echo '</span>';
                }
            }

            ezboozt_edit_link();

            echo '</footer> <!-- .entry-footer -->';
        }
    }
endif;


if (!function_exists( 'ezboozt_edit_link' )) :
    /**
     * Returns an accessibility-friendly link to edit a post or page.
     *
     * This also gives us a little context about what exactly we're editing
     * (post or page?) so that users understand a bit more where they are in terms
     * of the template hierarchy and their content. Helpful when/if the single-page
     * layout with multiple posts/pages shown gets confusing.
     */
    function ezboozt_edit_link() {
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'ezboozt' ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ezboozt_categorized_blog() {
    $category_count = get_transient( 'ezboozt_categories' );

    if (false === $category_count){
        // Create an array of all the categories that are attached to posts.
        $categories = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $category_count = count( $categories );

        set_transient( 'ezboozt_categories', $category_count );
    }

    // Allow viewing case of 0 or 1 categories in post preview.
    if (is_preview()){
        return true;
    }

    return $category_count > 1;
}


/**
 * Flush out the transients used in ezboozt_categorized_blog.
 */
function ezboozt_category_transient_flusher() {
    if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE){
        return;
    }
    // Like, beat it. Dig?
    delete_transient( 'ezboozt_categories' );
}

add_action( 'edit_category', 'ezboozt_category_transient_flusher' );
add_action( 'save_post', 'ezboozt_category_transient_flusher' );


/**
 *  Render Social Menu
 */
if (!function_exists( 'ezboozt_render_menu_social' )){
    function ezboozt_render_menu_social($classes = '') {
        if (has_nav_menu( 'social' )) : ?>
            <nav class="social-navigation" role="navigation"
                 aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'ezboozt' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'social',
                    'menu_class'     => 'social-links-menu ' . esc_attr($classes),
                    'depth'          => 1,
                    'link_before'    => '<span class="screen-reader-text">',
                    'link_after'     => '</span><i class="fa fa-link" aria-hidden="true"></i>',
                ) );
                ?>
            </nav><!-- .social-navigation -->
        <?php endif;
    }
}


if (!function_exists( 'ezboozt_build_link' )){
    function ezboozt_build_link($value) {
        $result       = array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' );
        $params_pairs = explode( '|', $value );
        if (!empty( $params_pairs )){
            foreach ($params_pairs as $pair) {
                $param = preg_split( '/\:/', $pair );
                if (!empty( $param[0] ) && isset( $param[1] )){
                    $result[$param[0]] = rawurldecode( $param[1] );
                }
            }
        }

        return $result;
    }
}

if (!function_exists( 'ezboozt_getExtraClass' )){
    function ezboozt_getExtraClass($el_class) {
        $output = '';
        if ('' !== $el_class){
            $output = ' ' . str_replace( '.', '', $el_class );
        }

        return $output;
    }
}