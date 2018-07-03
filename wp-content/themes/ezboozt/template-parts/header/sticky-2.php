<?php
$is_fullwith = get_theme_mod('otf_header_layout_sticky_full_width', false);
?>
<div id="opal-header-sticky" class="site-header-desktop">
    <div class="inner <?php echo filter_var($is_fullwith, FILTER_VALIDATE_BOOLEAN) ? 'container-fluid' : 'container'; ?>">
        <div class="row d-flex align-items-center">
            <?php if (!wp_is_mobile()): ?>
            <div class="col sticky-navigation">
                <div class="main-navigation">
                    {{{data.menu}}}
                </div>
            </div>
            <?php else:?>
            <div class="d-block d-xl-none">
                <button class="menu-toggle">
                    <i class="icon icon-1179"></i>
                    <span class="screen-reader-text"><?php _e('Menu', 'ezboozt'); ?></span>
                </button>
            </div>
            <?php endif;?>
            <div>
                {{{data.logo}}}
            </div>
            <# if(data.account || data.search || data.wishlist || data.cart){ #>
            <div class="col">
                <div class="action text-right">
                    {{{data.account}}}
                    {{{data.search}}}
                    {{{data.wishlist}}}
                    {{{data.cart}}}
                </div>
            </div>
            <# } #>
        </div>
    </div>
</div>