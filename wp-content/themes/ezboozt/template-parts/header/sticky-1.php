<?php
/**
 * data.logo
 * data.menu
 * data.menuFull
 * data.cart
 * data.search
 */
$is_fullwith = get_theme_mod('otf_header_layout_sticky_full_width', false);
?>
<div id="opal-header-sticky" class="site-header-desktop">
    <div class="inner <?php echo filter_var($is_fullwith, FILTER_VALIDATE_BOOLEAN) ? 'container-fluid' : 'container'; ?>">
        <div class="d-flex align-items-center">
            <div class="d-block d-xl-none">
                <button class="menu-toggle">
                    <i class="icon icon-1179"></i>
                    <span class="screen-reader-text"><?php _e('Menu', 'ezboozt'); ?></span>
                </button>
            </div>
            <div class="otf-flex-item d-block d-xl-none"></div>
            <div>
                {{{data.logo}}}
            </div>
            <div class="otf-flex-item d-none d-xl-block"></div>
            <div>
                <div class="main-navigation">
                    {{{data.menu}}}
                </div>
            </div>
            <# if(data.account || data.search || data.wishlist || data.cart || data.itemCustom){ #>
            <div class="otf-flex-item"></div>
            <div>
                <div class="action">
                    {{{data.account}}}
                    {{{data.search}}}
                    {{{data.wishlist}}}
                    {{{data.cart}}}
                    {{{data.itemCustom}}}
                </div>
            </div>
            <# } #>
        </div>
    </div>
</div>