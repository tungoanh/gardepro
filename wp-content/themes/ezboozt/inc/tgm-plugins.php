<?php
function ezboozt_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'      => 'Opal Core',
            'slug'      => 'opal-theme-framework',
            'required'  => true,
            'source'    => 'http://demo3.wpopal.com/boost/sample_data/opal-theme-framework.zip',
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/opal-core.png',
        ),
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => true,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/woocommerce.png',
        ),
        array(
            'name'      => 'Visual Composer',
            'slug'      => 'js_composer',
            'required'  => true,
            'source'    => 'http://www.wpopal.com/thememods/js_composer.zip',
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/visual-composer.png',
        ),
        array(
            'name'      => 'Slider Revolution',
            'slug'      => 'revslider',
            'required'  => true,
            'source'    => 'http://www.wpopal.com/thememods/revslider.zip',
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/rev-slider.png',
        ),
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/contact-form-7.jpg',
        ),
        array(
            'name'      => 'MailChimp',
            'slug'      => 'mailchimp-for-wp',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/mailchimp.png',
        ),
        array(
            'name'      => 'Ajax Search for WooCommerce',
            'slug'      => 'ajax-search-for-woocommerce',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/ajax-search-for-woocommerce.png',
        ),
        array(
            'name'      => 'YITH WooCommerce Quick View',
            'slug'      => 'yith-woocommerce-quick-view',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/yith-woocommerce-quick-view.jpg',
        ),
        array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/yith-woocommerce-wishlist.jpg',
        ),
        array(
            'name'      => 'YITH WooCommerce Compare',
            'slug'      => 'yith-woocommerce-compare',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/yith-woocommerce-compare.jpg',
        ),
        array(
            'name'      => 'Visual Composer Clipboard',
            'slug'      => 'vc_clipboard',
            'required'  => false,
            'source'    => 'http://demo3.wpopal.com/boost/sample_data/vc_clipboard.zip',
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/visual-clipboard.png',
        ),
        array(
            'name'      => 'WooCommerce Variation Swatches',
            'slug'      => 'variation-swatches-for-woocommerce',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/assets/images/plugin-thumbnails/variation-swatches-for-woocommerce.png',
        ),
    );

    /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
    $config = array(
        'id'           => 'ezboozt',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'ezboozt_register_required_plugins' );