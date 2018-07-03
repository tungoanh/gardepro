<div class="modal fade modal-user" id="opal-modal-login-register">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="opal-tabs tabs-style-flip" data-opal-tab>
                <nav class="opal-tab-nav">
                    <ul>
                        <li class="tab-current"><a
                                href="#opal-tab-login"><span><?php esc_html_e( 'Login', 'opal-theme-framework' ) ?></span></a></li>
                        <li><a href="#opal-tab-register"><span><?php esc_html_e( 'Register', 'opal-theme-framework' ) ?></span></a></li>
                    </ul>
                    <button type="button" class="btn btn-modal-close" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                </nav>
                <div class="opal-tab-content">
                    <div class="content-current" id="opal-tab-login">
                        <form id="opal-tab-login-form" data-toggle="validator" role="form">
                            <div class="opal-row">
                                <div class="col-sm-10 offset-sm-1">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <input name="username" type="text"
                                                   class="form-control" required
                                                   placeholder="<?php esc_attr_e( 'Username', 'opal-theme-framework' ) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                            <input name="password" type="password"
                                                   class="form-control" required
                                                   placeholder="<?php esc_attr_e( 'Password', 'opal-theme-framework' ) ?>">
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember"
                                                   type="checkbox"> <?php _e( 'Remember Me', 'opal-theme-framework' ) ?>
                                        </label>
                                    </div>
                                    <?php do_action( 'opalrealestate_captcha', 'login_form' ) ?>
                                    <button type="submit" data-button-action
                                            class="btn btn-primary btn-block"><?php _e( 'Login', 'opal-theme-framework' ) ?></button>
                                    <input type="hidden" name="action" value="opalrealestate_login">
                                    <?php wp_nonce_field( 'ajax-ore-login-nonce', 'security-login' ); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="opal-tab-register">
                        <div class="row opal-row">
                            <div class="col-sm-10 offset-sm-1">
                                <form id="opal-tab-register-form" data-toggle="validator">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" name="username"
                                                   placeholder="<?php esc_html_e( 'Username', 'opal-theme-framework' ); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            <input type="text" class="form-control" name="email"
                                                   placeholder="<?php esc_html_e( 'Email', 'opal-theme-framework' ); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="<?php esc_html_e( 'Password', 'opal-theme-framework' ); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" name="password2"
                                                   placeholder="<?php esc_html_e( 'Confirm Password', 'opal-theme-framework' ); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <?php  do_action( 'opalrealestate_captcha', 'register_form' ) ?>
                                    <button type="submit" data-button-action
                                            class="btn btn-primary btn-block"><?php _e( 'Register', 'opal-theme-framework' ) ?></button>
                                    <input type="hidden" name="action" value="opalrealestate_register">
                                    <?php wp_nonce_field( 'ajax-ore-register-nonce', 'security-register' ); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--                    Start Loading-->
                    <div class="opal-loader">
                        <div class="opal-loader-inner">
                            <label> ●</label>
                            <label> ●</label>
                            <label> ●</label>
                            <label> ●</label>
                            <label> ●</label>
                            <label> ●</label>
                        </div>
                    </div>
                    <!--                    End Loading-->
                </div><!-- /content -->
            </div><!-- /tabs -->
        </div>
    </div>
</div>
<div class="opal-modal-overlay"></div>