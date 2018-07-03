<?php
/**
 * Extend Recent Posts Widget
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

/**
 * Class OTF_Recent_Posts_Widget
 */
class OTF_Recent_Posts_Widget extends WP_Widget_Recent_Posts {


    public function widget($args, $instance) {
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }


        $title = (!empty($instance['title'])) ? $instance['title'] : __('Recent Posts', 'opal-theme-framework');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);


        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }
        $show_date  = isset($instance['show_date']) ? $instance['show_date'] : false;
        $show_image = isset($instance['show_image']) ? $instance['show_image'] : false;
        $image_size = (isset($instance['image_size']) && $instance['image_size'] != '') ? $instance['image_size'] : 'full';
        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @see   WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         */
        $r = new WP_Query(apply_filters('widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ), $instance));

        if (!$r->have_posts()) {
            return;
        }
        ?>
        <?php echo $args['before_widget']; ?>
        <?php
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <ul>
            <?php foreach ($r->posts as $recent_post) : ?>
                <?php
                $post_title = get_the_title($recent_post->ID);
                $title      = (!empty($post_title)) ? $post_title : __('(no title)', 'opal-theme-framework');
                ?>
                <li>
                    <?php
                    if ($show_image) {
                        $thumb_size = otf_get_image_size($image_size);
                        $image_id   = get_post_thumbnail_id($recent_post->ID);
                        $thumbnail  = wpb_resize($image_id, null, $thumb_size[0], $thumb_size[1], true);
                        if ($thumbnail) {
                            echo '<img title="' . esc_attr($title) . '" src="' . esc_attr($thumbnail["url"]) . '" width="' . esc_attr($thumbnail["width"]) . '" height="' . esc_attr($thumbnail["height"]) . '" alt="' . esc_attr($title) . '"/>';
                        }
                    }
                    ?>
                    <div class="post-content">
                        <a href="<?php the_permalink($recent_post->ID); ?>"><?php echo $title; ?></a>
                        <?php if ($show_date) : ?>
                            <span class="post-date"><?php echo get_the_date('', $recent_post->ID); ?></span>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }
}

class OTF_Account_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'otf_widget_account',
            'description'                 => __('Display Login/Register button when click then show popup', 'opal-theme-framework'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('otf-widget-accounts', __('OTF Login/Register Button', 'opal-theme-framework'), $widget_ops);
        $this->alt_option_name = 'otf_widget_account';
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo do_shortcode('[otf_header_account]');
        echo $args['after_widget'];
    }
}

function otf_widget_registration() {
    register_widget('OTF_Recent_Posts_Widget');
    register_widget('OTF_Account_Widget');
}

add_action('widgets_init', 'otf_widget_registration');