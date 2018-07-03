<?php
if (!defined('ABSPATH')) {
    die('-1');
}

//Shortcode: [otf_menu_social title="Connect with us" el_class=""]
$atts = shortcode_atts(array(
    'title'    => esc_html__('Connect with us', 'ezboozt'),
    'shape'    => 'square',
    'color'    => 'default',
    'align'    => 'text-left',
    'el_class' => '',

), $atts, 'otf_menu_social');
extract($atts);
$class = 'otf-menu-social ' . $shape . ' ' . $align . ' ' . $el_class . ' ' . $color;
?>
<div class="<?php echo esc_attr($class); ?>">
    <?php if (!empty($title)): ?>
        <span class="menu-social">
            <?php echo esc_html($title); ?>
        </span>
    <?php endif; ?>
    <?php ezboozt_render_menu_social(); ?>
</div>