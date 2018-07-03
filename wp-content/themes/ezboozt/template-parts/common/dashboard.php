<?php if (has_nav_menu('my-account')) : ?>
    <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'ezboozt'); ?>">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'my-account',
            'menu_class'     => 'account-links-menu',
            'depth'          => 1,
        ));
        ?>
    </nav><!-- .social-navigation -->
<?php else: $user = new WP_User(get_current_user_id()); ?>
    <ul class="account-dashboard">

        <?php if (ezboozt_is_woocommerce_activated()): ?>
                <li>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" title="<?php esc_html_e('Dashboard', 'ezboozt'); ?>"><?php esc_html_e('Dashboard', 'ezboozt'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" title="<?php esc_html_e('Orders', 'ezboozt'); ?>"><?php esc_html_e('Orders', 'ezboozt'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" title="<?php esc_html_e('Downloads', 'ezboozt'); ?>"><?php esc_html_e('Downloads', 'ezboozt'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" title="<?php esc_html_e('Edit Address', 'ezboozt'); ?>"><?php esc_html_e('Edit Address', 'ezboozt'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" title="<?php esc_html_e('Account Details', 'ezboozt'); ?>"><?php esc_html_e('Account Details', 'ezboozt'); ?></a>
                </li>
        <?php else: ?>
            <li>
                <a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>" title="<?php esc_html_e('Dashboard', 'ezboozt'); ?>"><?php esc_html_e('Dashboard', 'ezboozt'); ?></a>
            </li>
        <?php endif; ?>
        <li>
            <a title="<?php esc_html_e('Log out', 'ezboozt'); ?>" class="tips" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'ezboozt'); ?></a>
        </li>
    </ul>
<?php endif; ?>