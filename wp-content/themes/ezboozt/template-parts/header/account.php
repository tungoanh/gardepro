<?php
$classes = '';
if (!empty($atts['css'])) {
    $classes = ' ' . $atts['css'];
}
if (!empty($atts['style'])) {
    $classes .= ' style-' . $atts['style'];
}

if (ezboozt_is_woocommerce_activated()) {
    $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
} else {
    $account_link = wp_login_url();
}
?>
<div class="site-header-account d-inline-block  <?php echo esc_attr($classes); ?>">
    <?php if (!is_user_logged_in()) {
        echo '<a href="' . esc_html($account_link) . '" title="' . esc_html__('Login', 'ezboozt') . '">
                <span class="icon icon-1222"></span>
                <span class="account-label">
                    <span>' . esc_html__('Login', 'bicomart') . '</span>
                    <span>' . esc_html__('Register', 'bicomart') . '</span>
                </span>
              </a>';
    } else {
        $user = new WP_User(get_current_user_id());
        echo '<a href="' . esc_html($account_link) . '" title="' . esc_html__('My account', 'ezboozt') . '">
                <div class="account-avata d-inline-block">' . get_avatar($user->ID, 30,null, null, array('class' => array('rounded-circle','align-middle'))) . '</div><span class="account-label"><span class="label-name">' . $user->display_name . '</span><span>' . esc_html__('My account', 'bicomart') . '</span></span>
              </a>';
    }

    ?>
    <div class="account-dropdown <?php echo $atts['alignment'] ?>">
        <div class="account-wrap">
            <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                <?php if (!is_user_logged_in()) {
                    get_template_part('template-parts/common/login-form');
                } else {
                    get_template_part('template-parts/common/dashboard');
                }
                ?>
            </div>
        </div>
    </div>
</div>


