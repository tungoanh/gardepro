<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

//Shortcode: [otf_countdown datetime="2018-01-01" style="style-1" text_button="See more" btn_link="#" el_class=""]
$atts = shortcode_atts(array(
    'datetime'    => '',
    'style'       => 'style-1',
    'color'       => 'color-schema-dark',
    'text_button' => esc_html__('Click here', 'ezboozt'),
    'btn_link'    => '#',
    'el_class'    => '',
), $atts, 'otf_countdown');
extract($atts);

$enddays = strtotime( $datetime );
$enddays += (get_option('gmt_offset') * 3600);
if(!is_numeric($enddays)){
    return;
}

//parse link
$attributes = array();
$link = ( '||' === $btn_link ) ? '' : $btn_link;
$link = ezboozt_build_link($link);
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
    $use_link = true;
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'];
    $a_rel = $link['rel'];
}

if ( $use_link ) {
    $attributes[] = 'class="btn"';
    $attributes[] = 'href="' . trim( $a_href ) . '"';
    $attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
    if ( ! empty( $a_target ) ) {
        $attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
    }
    if ( ! empty( $a_rel ) ) {
        $attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
    }
    if(empty($text_button)){
        $text_button = $a_title;
    }
}
$attributes = implode( ' ', $attributes );

?>
<div class="otf-vc_countdown <?php echo esc_attr($color) .' '. esc_attr($el_class); ?>">
    <?php if ($enddays): ?>
        <div class="time">
            <div class="opal-countdown <?php echo esc_attr($style) ?> clearfix"
                 data-countdown="countdown"
                 data-days="<?php esc_html_e("days", "ezboozt") ?>"
                 data-hours="<?php esc_html_e("hours", "ezboozt") ?>"
                 data-minutes="<?php esc_html_e("minutes", "ezboozt") ?>"
                 data-seconds="<?php esc_html_e("seconds", "ezboozt") ?>"
                 data-Message="<?php esc_html_e('Expired', 'ezboozt') ?>"
                 data-date="<?php echo date('m', $enddays) . '-' . date('d', $enddays) . '-' . date('Y', $enddays) . '-' . date('H', $enddays) . '-' . date('i', $enddays) . '-' . date('s', $enddays) ?>
        ">
            </div>
            <?php if($use_link ): ?>
                <div><a <?php echo trim( $attributes); ?>><?php echo esc_html($text_button); ?></a></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>