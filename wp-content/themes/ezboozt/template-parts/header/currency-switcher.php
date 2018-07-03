<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
$currencies = get_option('woocs', array());
if (empty($currencies) OR !is_array($currencies) OR count($currencies) < 2 OR count($currencies) > 2) {
    $default = array(
        'USD' => array(
            'name' => 'USD',
            'rate' => 1,
            'symbol' => '&#36;',
            'position' => 'right',
            'is_etalon' => 0,
            'description' => 'USA dollar',
            'hide_cents' => 0,
            'flag' => '',
        ),
    );
    $wc_currency = get_option('woocommerce_currency');

    switch ($wc_currency) {
        case 'USD':
            $default['EUR'] = array(
                'name' => 'EUR',
                'rate' => 0.89,
                'symbol' => '&euro;',
                'position' => 'left_space',
                'is_etalon' => 0,
                'description' => 'European Euro',
                'hide_cents' => 0,
                'flag' => '',
            );
            $default['USD']['is_etalon'] = 1;
            break;
        case 'EUR':
            $default['EUR'] = array(
                'name' => 'EUR',
                'rate' => 1,
                'symbol' => '&euro;',
                'position' => 'left_space',
                'is_etalon' => 1,
                'description' => 'European Euro',
                'hide_cents' => 0,
                'flag' => '',
            );
            $default['USD']['rate'] = 1.3;
            break;
        default :
            $default[$wc_currency] = array(
                'name' => $wc_currency,
                'rate' => 1,
//                'symbol' => $this->get_default_currency_symbol($wc_currency),
                'position' => 'left_space',
                'is_etalon' => 1,
                'description' => '',
                'hide_cents' => 0,
                'flag' => '',
            );
            $default['USD']['rate'] = 1.25;
            $default['USD']['description'] = __('change the rate and this description to the right values', 'ezboozt');
            break;
    }

    $currencies = $default;
}
$currencies = apply_filters('woocs_currency_data_manipulation', $currencies);

$default_currency = 'USD';
if (!empty($currencies) AND is_array($currencies)) {
    foreach ($currencies as $key => $currency) {
        if ($currency['is_etalon']) {
            $default_currency = $key;
            break;
        }
    }
} else {
    return '';
}

//*** hide if there is checkout page
if (!class_exists('WooCommerce')) {
    echo "<div class='notice'>" . __('Warning: Woocommerce is not activated', 'ezboozt') . "</div>";
    return;
}
if (get_option('woocs_restrike_on_checkout_page', 0)) {
    if (get_option('woocommerce_checkout_page_id') == get_the_ID()) {
        return "";
    }
}

$storage = new WOOCS_STORAGE(get_option('woocs_storage', 'transient'));

if ($storage->is_isset('woocs_current_currency')) {
    $current_currency = $storage->get_val('woocs_current_currency');
} else {
    $current_currency = $default_currency;
}

if ($atts && is_array( $atts )){
    extract( $atts );
}
if(empty($css)){
    $css = '';
}
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_promo_banner', $atts);

?>

<div class="opal-currency_switcher <?php echo esc_attr($css_class)?>">
    <form class="opal-currency-mode" method="get">
        <ul class="currency_wrap">
            <li class="currency_select">
                <span><?php echo esc_html($current_currency); ?> <i class="fa fa-angle-down"></i></span>
                <ul class="list-currency">
                    <?php foreach ($currencies as $key => $currency) : ?>
                        <li <?php echo ($key === $current_currency) ? 'class="active"' : ''; ?>>
                            <button type="submit" name="currency" value="<?php echo esc_attr($key); ?>"><?php echo esc_html($currency['name']); ?></button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
        <?php
        foreach ($_GET as $key => $val) {
            if ('currency' === $key) {
                continue;
            }
            if (is_array($val)) {
                foreach ($val as $innerVal) {
                    echo '<input type="hidden" name="' . esc_attr($key) . '[]" value="' . esc_attr($innerVal) . '" />';
                }
            } else {
                echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
            }
        }
        ?>
    </form>
</div>

