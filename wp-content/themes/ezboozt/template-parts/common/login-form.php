<div class="login-form-head pb-1 mb-2 bb-so-1 bc">
    <span class="login-form-title"><?php esc_attr_e('Sign in', 'ezboozt') ?></span>
    <span class="pull-right pt-1">
        <a class="register-link" href="<?php echo wp_registration_url(); ?>"
           title="<?php esc_attr_e('Register', 'ezboozt'); ?>"><?php esc_attr_e('Create an Account', 'ezboozt'); ?></a>
    </span>
</div>
<form class="opal-login-form-ajax" data-toggle="validator" role="form">
    <p>
        <label><?php esc_attr_e('Username or email', 'ezboozt'); ?> <span class="required">*</span></label>
        <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'ezboozt') ?>">
    </p>
    <p>
        <label><?php esc_attr_e('Password', 'ezboozt'); ?> <span class="required">*</span></label>
        <input name="password" type="password" required placeholder="<?php esc_attr_e('Password', 'ezboozt') ?>">
    </p>
    <button type="submit" data-button-action class="btn btn-primary btn-block w-100 mt-1"><?php _e('Login', 'ezboozt') ?></button>
    <input type="hidden" name="action" value="opalrealestate_login">
    <?php wp_nonce_field('ajax-ore-login-nonce', 'security-login'); ?>
</form>
<div class="login-form-bottom">
    <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="mt-2 lostpass-link" title="<?php esc_attr_e('Lost your password?', 'ezboozt'); ?>"><?php esc_attr_e('Lost your password?', 'ezboozt'); ?></a>
</div>