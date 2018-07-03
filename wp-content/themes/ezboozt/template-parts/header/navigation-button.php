<?php
$classes = '';
if (!empty($atts['css'])) {
    $classes = ' ' . $atts['css'];
}
?>
<div class="navigation-button<?php echo esc_attr($classes); ?>">
    <button class="menu-toggle">
        <i class="icon icon-1179"></i>
        <?php _e('Menu', 'ezboozt'); ?>
    </button>
</div>
