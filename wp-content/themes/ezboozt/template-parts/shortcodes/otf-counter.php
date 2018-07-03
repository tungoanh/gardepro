<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

//Shortcode: [otf_counter style="default" number="1000" speed="2000" class=""]
$atts = shortcode_atts( array(
    'style'    => 'default',
    'title'    => '',
    'subtitle' => '',
    'number'   => 100,
    'speed'    => 2000,
    'type'     => '',
    'el_class' => '',
    'icon_fontawesome' => '',
    'icon_openiconic'  => '',
    'icon_typicons'    => '',
    'icon_entypo'      => '',
    'icon_linecons'    => '',
    'icon_monosocial'  => '',
    'icon_material'    => ''
), $atts, 'otf_counter' );
extract( $atts );

$html_icon = '';

if (!is_numeric( $number )){
    return;
}
if (function_exists( 'vc_icon_element_fonts_enqueue' )){
    if ($type === 'custom'){
        $img_icon  = wp_get_attachment_image_src( $photo, 'full' );
        $html_icon = '<img src="' . esc_url_raw( $img_icon[0] ) . '" alt="' . esc_attr( $title ) . '">';
    } elseif ($type === ''){
        $html_icon = '';
    } else{
        vc_icon_element_fonts_enqueue( $type );
        $iconClass = isset( ${'icon_' . $type} ) ? esc_attr( ${'icon_' . $type} ) : 'fa fa-adjust';
        $html_icon = '<i class="' . esc_attr( $iconClass ) . '"></i>';
    }
}
?>
<div class="otf-counter <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $atts['style'] ) ?>" otf-count-number>
    <?php echo wp_kses_post( $html_icon ); ?>
    <div class="counter" opal-counter data-to="<?php echo esc_attr( $number ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>">
        <?php echo esc_html( $number ); ?>
    </div>

    <div class="title">
        <?php echo esc_html( $title ); ?>
    </div>

    <?php if (!empty( $subtitle )): ?>
        <div class="subtitle">
            <?php echo esc_html( $subtitle ); ?>
        </div>
    <?php endif; ?>
</div>