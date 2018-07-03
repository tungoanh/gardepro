<?php
if (!defined('ABSPATH')) {
    die('-1');
}
//Shortcode: [otf_parallax el_class=""]
$atts = shortcode_atts(array(
    'enable_box_content'       => true,
    'box_style'                => 'square',
    'content_enable_reverse'   => true,
    'content_duration'         => 0.5,
    'select_main_image_source' => 'main_image_library',
    'main_image'               => '',
    'external_link_main_image' => '',
    'main_image_size'          => 'full',
    'main_duration'            => 0.5,
    'enable_reverse'           => true,
    'select_image2_source'     => 'image2_library',
    'image2'                   => '',
    'external_link_image2'     => '',
    'image2_size'              => 'full',
    'background_image'         => '',
    'background_duration'      => '',
    'enable_reverse2'          => true,
    'image2_duration'          => 0.5,
    'position'                 => 'right',
    'position_image'           => 'position_right',
    'position_image2'          => 'position_right',
    'el_class'                 => '',
), $atts, 'otf_parallax');
extract($atts);
$wrapper_classes = array(ezboozt_getExtraClass($el_class), 'parallax-padding');
$class_to_filter = implode(' ', array_filter($wrapper_classes));
?>
<div class="row <?php echo trim(esc_attr($class_to_filter)) ?>">
    <?php if ($enable_box_content): ?>
        <div class=" parallax-box-content align-items-center d-flex h-100 <?php echo esc_attr($position); ?>">
            <div class="opal-parallax <?php echo 'box-style-' . esc_attr($box_style); ?>"
                 data-reverse="<?php echo floatval($content_enable_reverse); ?>"
                 data-duration="<?php echo floatval($content_duration); ?>">
                <div>
                    <?php echo wp_kses_post($content); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12 <?php if ($enable_box_content): echo 'xs-' . esc_attr($position); endif; ?>">
        <?php
        $main_image_size = otf_get_image_size($main_image_size);
        if ($select_main_image_source == 'main_image_library') {
            $main_image = wpb_resize($main_image, null, $main_image_size[0], $main_image_size[1], true);
        } elseif ($select_main_image_source == 'main_image_external') {
            if (!preg_match('/^(https?\:\/\/|\/\/)/', $external_link_main_image)) {
                $external_link_main_image = 'http://' . $external_link_main_image;
            }
            $main_image['url'] = $external_link_main_image;
        }

        $image2_size = otf_get_image_size($image2_size);
        if ($select_image2_source == 'image2_library') {
            $image2 = wpb_resize($image2, null, $image2_size[0], $image2_size[1], true);
        } elseif ($select_image2_source == 'image2_external') {
            if (!preg_match('/^(https?\:\/\/|\/\/)/', $external_link_image2)) {
                $external_link_image2 = 'http://' . $external_link_image2;
            }
            $image2['url'] = $external_link_image2;
        }
        ?>
        <?php if ($image2 && isset($image2['url'])): ?>
            <img src="<?php echo esc_attr($image2['url']) ?>"
                 class="opal-parallax <?php echo esc_attr($position_image2) ?>"
                 data-reverse="<?php echo esc_attr($enable_reverse2); ?>"
                 data-duration="<?php echo esc_attr(floatval($image2_duration)); ?>"
                 alt="">
        <?php endif; ?>

        <?php if ($main_image && isset($main_image['url'])): ?>
            <img src="<?php echo esc_url_raw($main_image['url']); ?>"
                 class="opal-parallax <?php if (!empty($image2) && isset($image2['url'])): echo 'pl-absolute '; endif;
                 echo esc_attr($position_image); ?>" data-reverse="<?php echo esc_attr($enable_reverse); ?>"
                 data-duration="<?php echo floatval($main_duration); ?>" alt="">
        <?php endif; ?>
    </div>
</div>