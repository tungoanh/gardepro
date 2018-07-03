<?php
/**
 * @var OTF_Menu_Setup $this
 */
$plugins           = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
?>
<div class="wrap about-wrap opal-wrap">
    <h1 class="dashicons-before dashicons-admin-plugins"><?php esc_html_e('Plugins Required', 'opal-theme-framework') ?></h1>
    <?php  $this->get_tab_menu( 'plugins' ); ?>

    <div id="opal-install-plugins" class="opal-demo-theme-wrap opal-install-plugins">
        <div class="feature-section theme-browser rendered">
            <?php foreach ( $plugins as $plugin ) : ?>
                <?php
                $class = '';
                $plugin_status = '';
                $file_path = $plugin['file_path'];
                $plugin_action = $this->plugin_link( $plugin );

                // We have a repo plugin.
                if ( ! $plugin['version'] ) {
                    $plugin['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $plugin['slug'] );
                }

                if ( is_plugin_active( $file_path ) ) {
                    $plugin_status = 'active';
                    $class = 'active';
                }
                ?>
                <div class="theme <?php echo esc_attr( $class ); ?>">
                    <div class="theme-wrapper">
                        <div class="theme-screenshot">
                            <img src="<?php echo esc_url_raw( $plugin['image_url'] ); ?>" alt="" />
                        </div>
                        <?php if ( isset( $plugin_action['update'] ) && $plugin_action['update'] ) : ?>
                            <div class="update-message notice inline notice-warning notice-alt" style="display: block!important;">
                                <p><?php printf( esc_attr__( 'New Version Available: %s', 'opal-theme-framework' ), esc_attr( $plugin['version'] ) ); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="theme-id-container">
                            <h3 class="theme-name">
                                <?php if ( 'active' == $plugin_status ) : ?>
                                    <span><?php printf( esc_attr__( 'Active: %s', 'opal-theme-framework' ), esc_attr( $plugin['name'] ) ); ?></span>
                                <?php else : ?>
                                    <?php echo esc_attr( $plugin['name'] ); ?>
                                <?php endif; ?>
                            </h3>
                            <div class="theme-actions">
                                <?php foreach ( $plugin_action as $action ) : ?>
                                    <?php
                                    echo $action;
                                    ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php if ( isset( $plugin['required'] ) && $plugin['required'] ) : ?>
                            <div class="plugin-required">
                                <?php esc_html_e( 'Required', 'opal-theme-framework' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>