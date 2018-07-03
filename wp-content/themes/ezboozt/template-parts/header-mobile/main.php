<div class="d-flex flex-nowrap">
    <div class="col d-flex align-items-center justify-content-center">
        <button class="menu-toggle">
            <i class="icon icon-1179"></i>
            <span class="screen-reader-text"><?php _e('Menu', 'ezboozt'); ?></span>
        </button>
    </div>
    <div class="col col-6 d-flex dropdown justify-content-center align-items-center">
        <?php
        get_template_part('template-parts/header/site', 'branding');
        ?>
    </div>
    <div class="col cart-mobile d-flex justify-content-center align-items-center">
        <?php
        if (class_exists('OpalThemeFramework')) {
            get_template_part('template-parts/header/cart');
        }
        ?>
    </div>
</div>
<div class="d-flex flex-nowrap">
    <div class=" search-mobile d-flex dropdown justify-content-center align-items-center px-0 w-100">
        <?php
        if (class_exists('DGWT_WC_Ajax_Search') && class_exists('WooCommerce')) {
            $_id = wp_generate_uuid4();
            echo preg_replace('#(id|for)="dgwt-wcas-search"#', '$1="dgwt-wcas-search-' . $_id . '"', ezboozt_do_shortcode('wcas-search-form') . '');
        } else {
            get_search_form();
        }
        ?>
    </div>
</div>