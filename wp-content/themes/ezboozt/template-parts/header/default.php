<?php
$container = get_theme_mod('otf_header_width', false) ? 'container-fluid' : 'container';
?>

<div id="topbar" class="top-bar">
    <div class="<?php echo esc_attr($container) ?>">
        <?php get_template_part('template-parts/header/topbar'); ?>
    </div>
</div>
<div id="opal-header-content" class="header-content">
    <div class="custom-header <?php echo esc_attr($container) ?>">
        <div class="header-main-content w-100 d-flex justify-content-between align-items-center<?php echo get_theme_mod('otf_header_layout_is_sticky', false) ? ' opal-element-sticky' : ''; ?>">
            <?php get_template_part('template-parts/header/site', 'branding'); ?>
            <?php if (has_nav_menu('top')) : ?>
                <div class="navigation-top">
                    <?php get_template_part('template-parts/header/navigation'); ?>
                </div><!-- .navigation-top -->
            <?php endif; ?>
        </div>
    </div>
</div>
