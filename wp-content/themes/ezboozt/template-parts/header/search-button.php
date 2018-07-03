<?php
$id   = wp_generate_uuid4();
$skin = '';
if ($atts && is_array( $atts )){
    extract( $atts );
}

$classes = '';
if (!empty($atts['css'])) {
    $classes = ' ' . $atts['css'];
}

?>
<div class="site-header-search d-inline-block <?php echo esc_attr($classes); ?>">
    <a class="search-button <?php echo esc_attr($skin) ?>" data-search-toggle="toggle" data-target=".<?php echo esc_attr( $id ); ?>">
        <i class="icon icon-606"></i>
        <span class="screen-reader-text"><?php _e( 'Search', 'ezboozt' ); ?></span>
    </a>
    <div class="otf-dropdown <?php echo esc_attr($skin).' '.esc_attr( $id ); ?>">
        <span data-search-toggle="close" class="icon icon-1191"></span>
        <div class="container">
            <div class="row">
                <?php get_template_part( 'template-parts/header/search-form' ) ?>
            </div>
        </div>
    </div>
</div>