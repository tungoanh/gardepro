<?php
//Shortcode: [otf_team columns="4" total_items="4" layout="grid" class=""]
$atts = shortcode_atts(array(
    'columns'      => 4,
    'total_items'  => 4,
    'style'        => 'style-1',
    'layout'       => 'grid',
    'columns_grid' => 3,
    'show_dot'     => false,
    'show_nav'     => true
), $atts, 'otf_team');
extract($atts);

$start_wrap = '';
if ($layout === 'grid') {
    $start_wrap = '<div class="row" data-opal-columns="' . esc_attr($columns_grid) . '">';
} else if ($layout === 'carousel') {
    $dot = ($show_dot) ? 'true' : 'false';
    $nav = ($show_nav) ? 'true' : 'false';
    $start_wrap = '<div class="owl-carousel owl-theme" data-opal-carousel data-items="' . esc_attr($columns) . '" data-dots="' . esc_attr($dot) . '" data-nav="' . esc_attr($nav) . '">';
}
$query = OTF_Custom_Post_Type_Team::getInstance()->create_query($total_items);
if ($query->have_posts()): ?>
    <div class="otf-teams otf-teams-<?php echo esc_attr($style); ?>">
        <?php echo apply_filters('ezboozt_otf_team_start', $start_wrap); ?>
        <?php while ($query->have_posts()): $query->the_post(); ?>
            <div class="item team column-item">
                <div class="team-wrapper">
                    <div class="avatar">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="team-meta">
                        <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>" target="_blank">
                            <?php the_title(); ?>
                        </a>
                        <div class="job">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'otf_team_job', true)); ?>
                        </div>
                        <div class="content-desc">
                            <?php the_excerpt();?>
                        </div>
                    </div>
                    <div class="social">
                        <?php OTF_Custom_Post_Type_Team::getInstance()->show_social(get_the_ID()); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <!--    End brand wrap-->
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
