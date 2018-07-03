<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OTF_Menu_Setup
 */
class OTF_Menu_Setup {

    private $include_screens_path;

    /**
     * @var WP_Theme
     */
    public $my_theme;


    /**
     * OTF_Theme_Setup constructor.
     */
    public function __construct() {
        // Require plugin.php to use is_plugin_active() below
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $this->include_screens_path = trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_DIR ) . 'inc/admin/screens/';
        $this->my_theme             = wp_get_theme();

        add_filter( 'opal_theme_customize_layout_content', array( $this, 'layout_content' ) );
        add_filter( 'pt-ocdi/plugin_page_setup', array( $this, 'custom_menu_import' ) );
        add_filter( 'pt-ocdi/plugin_page_title', array( $this, 'add_screen_header' ), 1 );
        add_filter( 'tgmpa_notice_action_links', array( $this, 'edit_tgmpa_notice_action_links' ) );

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'create_admin_menus' ), 9 );
        add_action( 'admin_menu', array( $this, 'edit_admin_menus' ), 999 );

        add_action( 'cmb2_admin_init', array($this, 'add_license_page') );

    }

    public function add_license_page() {
        /**
         * Registers options page menu item and form.
         */
        $cmb = new_cmb2_box( array(
            'id'           => 'opal-theme-license',
            'title'        => esc_html__( 'License', 'opal-theme-framework' ),
            'object_types' => array( 'options-page' ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'      => 'opal-theme-license', // The option key and admin menu page slug.
            'parent_slug'     => 'opal-theme', // Make options page a submenu item of the themes menu.
            // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
            // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
            // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
            // 'message_cb'      => 'yourprefix_options_page_message_callback',
        ) );
        $cmb->add_field( array(
            'name'    => esc_html__( 'User Name Envato', 'opal-theme-framework' ),
            'id'      => 'username',
            'type'    => 'text',
            'default' => '',
        ) );

        $cmb->add_field( array(
            'name'    => esc_html__( 'Purchase Code', 'opal-theme-framework' ),
            'id'      => 'purchased_code',
            'type'    => 'text',
            'default' => '',
        ) );
    }

    /**
     * Actions to run on initial theme activation.
     *
     * @return void
     */
    public function admin_init() {

        if (current_user_can( 'edit_theme_options' )){

            if (isset( $_GET['opal-deactivate'] ) && 'deactivate-plugin' === $_GET['opal-deactivate']){
                check_admin_referer( 'opal-deactivate', 'opal-deactivate-nonce' );

                $plugins = TGM_Plugin_Activation::$instance->plugins;

                foreach ($plugins as $plugin) {
                    if (isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin']){
                        deactivate_plugins( $plugin['file_path'] );
                    }
                }
            }
            if (isset( $_GET['opal-activate'] ) && 'activate-plugin' === $_GET['opal-activate']){
                check_admin_referer( 'opal-activate', 'opal-activate-nonce' );

                $plugins = TGM_Plugin_Activation::$instance->plugins;

                foreach ($plugins as $plugin) {
                    if (isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin']){
                        activate_plugin( $plugin['file_path'] );

                        wp_safe_redirect( admin_url( 'admin.php?page=opal-theme-plugins' ) );
                        exit;
                    }
                }
            }
        }
    }


    /**
     * Removes install link for Fusion Builder, if Fusion Core was not updated to 3.0
     *
     * @since 5.0.0
     *
     * @param array $action_links The action link(s) for a required plugin.
     *
     * @return array The action link(s) for a required plugin.
     */
    public function edit_tgmpa_notice_action_links($action_links) {
        $current_screen = get_current_screen();

        if ('opal-theme-plugins' == $current_screen->id){
            $link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="#opal-install-plugins">' . esc_attr__( 'Manage Plugins Below', 'opal-theme-framework' ) . '</a>';
        } else{
            $link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="' . esc_url( self_admin_url( 'admin.php?page=opal-theme-plugins' ) ) . '#opal-install-plugins">' . esc_attr__( 'Go Manage Plugins', 'opal-theme-framework' ) . '</a>';
        }

        $action_links  = array( 'install' => $link_template, 'dismiss' => $action_links['dismiss'] );

        return $action_links;
    }

    public function add_screen_header($content) {
        ob_start();
        $this->get_tab_menu( 'demos' );
        $content .= ob_get_clean();

        return $content;
    }

    public function create_admin_menus() {
        global $pagenow;
        add_menu_page(
            'Opal Theme',
            'Opal Theme',
            'import',
            'opal-theme',
            array( $this, 'welcome_screen' ),
            OPAL_THEME_FRAMEWORK_PLUGIN_URL . '/assets/images/menu-icon-red.png',
            2
        );

        add_submenu_page( 'opal-theme',
            'Plugins',
            'Plugins',
            'manage_options',
            'opal-theme-plugins',
            array( $this, 'plugins_screen' )
        );

        // Redirect to Opal welcome page after activating theme.
        if (is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true'){

            // Add do action
            do_action( 'otf_activate' );

            // Redirect
            wp_redirect( admin_url( 'admin.php?page=opal-theme' ) );
        }
    }

    public function edit_admin_menus() {
        global $submenu;

        if (current_user_can( 'edit_theme_options' )){
            $submenu['opal-theme'][0][0] = esc_attr__( 'Welcome', 'opal-theme-framework' );
        }
    }

    /**
     * @param $args array
     */
    public function custom_menu_import($args) {
        $args['parent_slug'] = 'opal-theme';
        $args['menu_title']  = __( 'Import Demos', 'opal-theme-framework' );

        return $args;
    }

    public function welcome_screen() {
        require_once $this->include_screens_path . 'welcome.php';
    }

    public function plugins_screen() {
        require_once $this->include_screens_path . 'plugins.php';
    }

    public function layout_content() {
        return is_front_page();
    }

    /**
     * Get the plugin link.
     *
     * @access  public
     *
     * @param array $item The plugin in question.
     *
     * @return  array
     */
    public function plugin_link($item) {
        $installed_plugins = get_plugins();

        $item['sanitized_plugin'] = $item['name'];

        $actions = array();

        // We have a repo plugin.
        if (!$item['version']){
            $item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
        }

        $disable_class = '';
        $data_version  = '';


        // We need to display the 'Install' hover link.
        if (!isset( $installed_plugins[$item['file_path']] )){
            if (!$disable_class){
                $url = esc_url( wp_nonce_url(
                    add_query_arg(
                        array(
                            'page'          => rawurlencode( TGM_Plugin_Activation::$instance->menu ),
                            'plugin'        => rawurlencode( $item['slug'] ),
                            'plugin_name'   => rawurlencode( $item['sanitized_plugin'] ),
                            'tgmpa-install' => 'install-plugin',
                            'return_url'    => 'opal-theme-plugins',
                        ),
                        TGM_Plugin_Activation::$instance->get_tgmpa_url()
                    ),
                    'tgmpa-install',
                    'tgmpa-nonce'
                ) );
            } else{
                $url = '#';
            }
            $actions = array(
                'install' => '<a href="' . $url . '" class="button button-primary' . $disable_class . '"' . $data_version . ' title="' . sprintf( esc_attr__( 'Install %s', 'opal-theme-framework' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Install', 'opal-theme-framework' ) . '</a>',
            );
        } elseif (is_plugin_inactive( $item['file_path'] )){
            // We need to display the 'Activate' hover link.
            $url = esc_url( add_query_arg(
                array(
                    'plugin'              => rawurlencode( $item['slug'] ),
                    'plugin_name'         => rawurlencode( $item['sanitized_plugin'] ),
                    'opal-activate'       => 'activate-plugin',
                    'opal-activate-nonce' => wp_create_nonce( 'opal-activate' ),
                ),
                admin_url( 'admin.php?page=opal-theme-plugins' )
            ) );

            $actions = array(
                'activate' => '<a href="' . $url . '" class="button button-primary"' . $data_version . ' title="' . sprintf( esc_attr__( 'Activate %s', 'opal-theme-framework' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Activate', 'opal-theme-framework' ) . '</a>',
            );
        } elseif (version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' )){
            $disable_class = '';
            // We need to display the 'Update' hover link.
            $url     = wp_nonce_url(
                add_query_arg(
                    array(
                        'page'         => rawurlencode( TGM_Plugin_Activation::$instance->menu ),
                        'plugin'       => rawurlencode( $item['slug'] ),
                        'tgmpa-update' => 'update-plugin',
                        'version'      => rawurlencode( $item['version'] ),
                        'return_url'   => 'opal-theme-plugins',
                    ),
                    TGM_Plugin_Activation::$instance->get_tgmpa_url()
                ),
                'tgmpa-update',
                'tgmpa-nonce'
            );
            $actions = array(
                'update' => '<a href="' . $url . '" class="button button-primary' . $disable_class . '" title="' . sprintf( esc_attr__( 'Update %s', 'opal-theme-framework' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Update', 'opal-theme-framework' ) . '</a>',
            );
        } elseif (is_plugin_active( $item['file_path'] )){
            $url     = esc_url( add_query_arg(
                array(
                    'plugin'                => rawurlencode( $item['slug'] ),
                    'plugin_name'           => rawurlencode( $item['sanitized_plugin'] ),
                    'opal-deactivate'       => 'deactivate-plugin',
                    'opal-deactivate-nonce' => wp_create_nonce( 'opal-deactivate' ),
                ),
                admin_url( 'admin.php?page=opal-theme-plugins' )
            ) );
            $actions = array(
                'deactivate' => '<a href="' . $url . '" class="button button-primary" title="' . sprintf( esc_attr__( 'Deactivate %s', 'opal-theme-framework' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Deactivate', 'opal-theme-framework' ) . '</a>',
            );
        }

        return $actions;
    }

    /**
     * Renders the admin screens header with title, logo and tabs.
     *
     * @since   5.0.0
     *
     * @access  public
     *
     * @param string $screen The current screen.
     *
     * @return void
     */
    public function get_tab_menu($screen = 'welcome') {
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo esc_url_raw( ( 'welcome' === $screen ) ? '#' : admin_url( 'admin.php?page=opal-theme' ) ); ?>" class="<?php echo ( 'welcome' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Welcome', 'opal-theme-framework' ); ?></a>
            <a href="<?php echo esc_url_raw( ( 'plugins' === $screen ) ? '#' : admin_url( 'admin.php?page=opal-theme-plugins' ) ); ?>" class="<?php echo ( 'plugins' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Plugins', 'opal-theme-framework' ); ?></a>
            <a href="<?php echo esc_url_raw( ( 'demos' === $screen ) ? '#' : admin_url( 'admin.php?page=pt-one-click-demo-import' ) ); ?>" class="<?php echo ( 'demos' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Demos', 'opal-theme-framework' ); ?></a>
        </h2>
        <?php
    }
}