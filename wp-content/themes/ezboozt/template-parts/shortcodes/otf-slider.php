<?php
//Shortcode: [otf_slider style="style1" class=""]
$atts = shortcode_atts(array(
    'category'         => '',
    'style'            => 'style1',
    'style'            => '',
    'interval_timeout' => 5000,
    'show_dot'         => true,
    'show_nav'         => true,
), $atts, 'otf_slider');
extract($atts);
if(empty( $category)) return;
$start_wrap = '';
$dot = ($show_dot) ? 'true' : 'false';
$nav = ($show_nav) ? 'true' : 'false';
$query = OTF_Custom_Post_Type_Slider::getInstance()->create_query(-1, $category);
if ($query->have_posts()):
    ?>
    <div class="otf-slider <?php echo esc_attr($style); ?>">
        <div class="owl-carousel owl-theme" id="opal-carousel-slider" data-opal-carousel
             data-items="1" data-dots="<?php echo esc_attr($dot); ?>" data-nav="<?php echo esc_attr($show_nav); ?>"
             data-loop="true" data-autoplay="true"
             data-autoplay-timeout="<?php echo esc_attr($interval_timeout); ?>">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <?php
                    if (has_post_thumbnail()){
                        $style = 'background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(\''.get_the_post_thumbnail_url( get_the_ID(),'full' ).'\') no-repeat center center';
                    }else{
                        $style = '';
                    }
                ?>
                <div class="item slider column-item" style="<?php echo trim($style);?>">
                    <div class="content"><?php the_content(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else: ?>
    <?php get_template_part('template-parts/post/content', 'none'); ?>
<?php endif;