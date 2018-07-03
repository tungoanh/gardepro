<?php
//Shortcode: [otf_portfolio columns="4" total_items="12" layout="grid"]
$atts = shortcode_atts( array(
    'columns'     => 3,
    'total_items' => 6,
    'animation'   => 'none',
    'taxonomies'  => '',
    'layout'      => 'grid'
), $atts, 'otf_portfolio' );
extract( $atts );

if($taxonomies && !empty( $taxonomies)){
    $taxonomies = explode(',' ,$taxonomies);
}

$query = OTF_Custom_Post_Type_Portfolio::create_query($total_items, $taxonomies );
if( $query->have_posts()): ?>
    <?php if($layout == 'grid'): ?>
        <div class="portfolio" data-opal-columns="<?php echo esc_attr($columns) ?>">
            <?php while($query->have_posts()): $query->the_post(); ?>
            <div class="item column-item">
                <?php get_template_part( 'template-parts/portfolio/content' ); ?>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="portfolio-container" isotope-filter>
            <div class="nav-inner">
                <ul class="nav nav-tabs isotope-filter">
                    <?php
                    $terms = OTF_Custom_Post_Type_Portfolio::getInstance()->get_terms();
                    echo '<li class="btn active fil-cat"><a href="javascript:void(0)" data-rel=".all">' . esc_html__('All', 'ezboozt') . '</a></li>';

                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<li class="btn fil-cat"><a href="javascript:void(0)" data-rel=".' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="portfolio" data-opal-columns="<?php echo esc_attr($columns) ?>">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <?php
                        $item_classes = ' all ';
                        $item_cats = OTF_Custom_Post_Type_Portfolio::getInstance()->get_the_terms(get_the_ID());
                        foreach ((array)$item_cats as $item_cat) {
                            if (!empty($item_cats) && !is_wp_error($item_cats)) {
                                $item_classes .= $item_cat->slug . ' ';
                            }
                        }
                    ?>
                    <div class="item column-item<?php echo esc_attr($item_classes); ?>">
                        <?php get_template_part('template-parts/portfolio/content'); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
<?php else: ?>
    <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
<?php endif;