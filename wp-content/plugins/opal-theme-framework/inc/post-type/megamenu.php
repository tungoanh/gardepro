<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Megamenu
 */
class OTF_Custom_Post_Type_Megamenu extends OTF_Custom_Post_Type_Abstract {
    public $post_type = 'megamenu';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Megamenu
     */
    public static function getInstance() {
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Megamenu )){
            self::$instance = new OTF_Custom_Post_Type_Megamenu();
        }

        return self::$instance;
    }

    public function __construct() {
        parent::__construct();
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'custom_nav_item' ) );
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'custom_nav_edit_walker' ), 10, 2 );
        add_action( 'wp_update_nav_menu_item', array( $this, 'custom_nav_update' ), 10, 3 );
        add_action( 'otf_megamenu_item_config', array( $this, 'add_extra_fields_menu_config' ) );
        add_action( 'otf_megamenu_item_config_toplevel', array( $this, 'megamenu_item_config_toplevel' ) );

    }

    public function create_post_type() {
        $labels = array(
            'name'               => __( 'Megamenu', "opal-theme-framework" ),
            'singular_name'      => __( 'Megamenu', "opal-theme-framework" ),
            'add_new'            => __( 'Add Profile', "opal-theme-framework" ),
            'add_new_item'       => __( 'Add Profile', "opal-theme-framework" ),
            'edit_item'          => __( 'Edit Profile', "opal-theme-framework" ),
            'new_item'           => __( 'New Profile', "opal-theme-framework" ),
            'view_item'          => __( 'View Profile', "opal-theme-framework" ),
            'search_items'       => __( 'Search Profile', "opal-theme-framework" ),
            'not_found'          => __( 'No Profiles found', "opal-theme-framework" ),
            'not_found_in_trash' => __( 'No Profiles found in Trash', "opal-theme-framework" ),
            'parent_item_colon'  => __( 'Parent Profile:', "opal-theme-framework" ),
            'menu_name'          => __( 'Megamenu', "opal-theme-framework" ),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => 'List Megamenu',
            'supports'            => array( 'title', 'editor' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'has_archive'         => false,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => false,
        );
        register_post_type( $this->post_type, $args );

        if (isset( $_GET['reset'] ) && isset( $_GET['group'] ) && $_GET['group']){
            delete_option( 'megamenu_data_saved_' . $_GET['group'] );
        }
        if (isset( $_POST['megamenu_data_saved'] )){
            update_option( 'megamenu_data_saved_' . $_POST['menu-group'], $_POST[$this->post_type] );
        }
    }

    private function init_shortcodes() {
        $shortCodes = self::add_shortcode();
        foreach ($shortCodes as $shortCode) {
            add_shortcode( $shortCode, array( $this, $shortCode . '_shortcode' ) );
            if (class_exists( 'Vc_Manager' )){
                if (file_exists( trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_DIR ) . 'inc/vendors/visual-composer/settings/' . $shortCode . '.php' )){
                    vc_lean_map( $shortCode, null, trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_DIR ) . 'inc/vendors/visual-composer/settings/' . $shortCode . '.php' );
                }
            }
        }
    }

    /**
     * @param        $name
     * @param        $atts
     * @param string $content
     *
     * @return string
     */
    public function render_shortcode($name, $atts, $content = '') {
        $name = preg_replace( '/_/', '-', $name ) . '.php';
        $path = include locate_template( 'template-parts/shortcodes/' . $name );
        if (file_exists( $path )){
            include $path;
        }

        return '';
    }

    /**
     * @return array
     */
    public function add_shortcode() {
        return array(
            'otf_vertical_menu',
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function otf_vertical_menu_shortcode($atts, $content = '') {
        ob_start();
        $this->render_shortcode( 'otf_vertical_menu', $atts, $content );

        return ob_get_clean();
    }

    public function megamenu_profiles_query() {
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'post_type'        => $this->post_type,
            'suppress_filters' => true,
        );

        return get_posts( $args );
    }

    public function custom_nav_update($menu_id, $menu_item_db_id, $args) {
        $fields = array( 'text_customize', 'megamenu', 'alignment', 'width', 'icon' );
        foreach ($fields as $field) {
            if (!isset( $_POST['menu-item-' . $field][$menu_item_db_id] )){
                $_POST['menu-item-' . $field][$menu_item_db_id] = "";
            }
            $custom_value = $_POST['menu-item-' . $field][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, $field, $custom_value );
        }
    }

    public function custom_nav_item($menu_item) {
        $fields = array( 'text_customize', 'megamenu', 'alignment', 'width' );
        foreach ($fields as $field) {
            $menu_item->{$field} = get_post_meta( $menu_item->ID, $field, true );
        }

        return $menu_item;
    }

    function add_extra_fields_menu_config($item, $depth = 0) {
        $item_id = esc_attr( $item->ID );
        ?>
        <p class="field-addclass description description-wide">
            <label for="edit-menu-item-text_customize-<?php echo esc_attr( $item_id ); ?>">
                <?php echo __( 'Label', "opal-theme-framework" ); ?><br/>
                <select name="menu-item-text_customize[<?php echo esc_attr( $item_id ); ?>]">
                    <option value="" <?php selected( esc_attr( $item->text_customize ), '' ); ?>><?php _e( 'None', "opal-theme-framework" ); ?></option>
                    <option value="text_new" <?php selected( esc_attr( $item->text_customize ), 'text_new' ); ?>><?php _e( 'New', "opal-theme-framework" ); ?></option>
                    <option value="text_hot" <?php selected( esc_attr( $item->text_customize ), 'text_hot' ); ?>><?php _e( 'Hot', "opal-theme-framework" ); ?></option>
                    <option value="text_featured" <?php selected( esc_attr( $item->text_customize ), 'text_featured' ); ?>><?php _e( 'Featured', "opal-theme-framework" ); ?></option>
                </select>
            </label>
        </p>
        <?php
    }

    public function megamenu_item_config_toplevel($item) {
        $item_id     = esc_attr( $item->ID );
        $posts_array = $this->megamenu_profiles_query();
        ?>

        <p class="field-addclass description description-wide">
            <label for="edit-menu-item-megamenu-<?php echo esc_attr( $item_id ); ?>">
                <?php _e( 'Megamenu Profile', 'opal-theme-framework' ); ?> <br>
                <select name="menu-item-megamenu[<?php echo esc_attr( $item_id ); ?>]">
                    <option value=""><?php _e( 'Disable', "opal-theme-framework" ); ?></option>
                    <?php foreach ($posts_array as $_post) { ?>
                        <option value="<?php echo esc_attr( $_post->ID ); ?>" <?php selected( esc_attr( $item->megamenu ), $_post->ID ); ?> ><?php echo esc_html( $_post->post_title ); ?></option>
                    <?php } ?>
                </select>
            </label>

            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=megamenu' ) ); ?>" target="_blank" title="<?php _e( 'Profiles Management', "opal-theme-framework" ); ?>"><?php _e( 'Profiles Management', "opal-theme-framework" ); ?></a>
            <span><?php _e( 'If enabled megamenu, its submenu will be disabled', "opal-theme-framework" ); ?></span>
        </p>
        <?php
        $aligns = array(
            'left'      => __( 'Left', "opal-theme-framework" ),
            'right'     => __( 'Right', "opal-theme-framework" ),
            'justify'   => __( 'justify', 'opal-theme-framework' ),
            'fullwidth' => __( 'Fullwidth', "opal-theme-framework" ),
        );
        ?>
        <p class="field-alignment description description-wide">
            <label for="edit-menu-item-alignment-<?php echo esc_attr( $item_id ); ?>">
                <?php _e( 'Alignment:', "opal-theme-framework" ); ?>
                <br>
                <select name="menu-item-alignment[<?php echo esc_attr( $item_id ); ?>]">
                    <?php foreach ($aligns as $key => $align) { ?>
                        <option <?php selected( esc_attr( $item->alignment ), $key ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $align ); ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p class="field-width description description-wide">
            <label for="edit-menu-item-width-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Width:', "opal-theme-framework" ); ?>
                <br>
                <input type="text" name="menu-item-width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->width ); ?>">
            </label>
        </p>

        <p class="field-icon description description-wide">
            <label for="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Icon:', "opal-theme-framework" ); ?>
                <br>
                <input type="text" name="menu-item-icon[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->icon ); ?>">
            </label>
        </p>


        <?php
    }

    public function custom_nav_edit_walker($walker, $menu_id) {
        return 'OTF_Themer_Megamenu_Config';
    }
}

OTF_Custom_Post_Type_Megamenu::getInstance();


if (!class_exists( 'OTF_Themer_Megamenu_Config' )){
    class OTF_Themer_Megamenu_Config extends Walker_Nav_Menu {
        /**
         * @see   Walker_Nav_Menu::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        public function start_lvl(&$output, $depth = 0, $args = array()) {
        }

        /**
         * @see   Walker_Nav_Menu::end_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        public function end_lvl(&$output, $depth = 0, $args = array()) {
        }

        /**
         * @see   Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param object $args
         */
        public function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
//            echo '<pre>';
//            var_dump($item);
//            die;
            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            ob_start();
            $item_id      = esc_attr( $item->ID );
            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = '';
            if ('taxonomy' == $item->type){
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if (is_wp_error( $original_title )){
                    $original_title = false;
                }
            } elseif ('post_type' == $item->type){
                $original_object = get_post( $item->object_id );
                $original_title  = $original_object->post_title;
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
            );

            $title = $item->title;

            if (!empty( $item->_invalid )){
                $classes[] = 'menu-item-invalid';
                /* translators: %s: title of menu item which is invalid */
                $title = sprintf( __( '%s (Invalid)', "opal-theme-framework" ), $item->title );
            } elseif (isset( $item->post_status ) && 'draft' == $item->post_status){
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( __( '%s (Pending)', "opal-theme-framework" ), $item->title );
            }

            $title = empty( $item->label ) ? $title : $item->label;

            ?>
            <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode( ' ', $classes ); ?>">
                <dl class="menu-item-bar">
                    <dt class="menu-item-handle">
                        <span class="item-title"><?php echo esc_html( $title ); ?></span>
                        <span class="item-controls">
                                <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                                <span class="item-order hide-if-js">
                                    <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action'    => 'move-up-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                    ?>" class="item-move-up"><abbr title="<?php esc_attr_e( 'Move up', 'opal-theme-framework' ); ?>">&#8593;</abbr></a>
                                    |
                                    <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action'    => 'move-down-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                    ?>" class="item-move-down"><abbr title="<?php esc_attr_e( 'Move down', 'opal-theme-framework' ); ?>">&#8595;</abbr></a>
                                </span>
                                <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'opal-theme-framework' ); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                                ?>"><?php _e( 'Edit Menu Item', "opal-theme-framework" ); ?></a>
                            </span>
                    </dt>
                </dl>

                <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                    <?php if ('custom' == $item->type) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                                <?php _e( 'URL', "opal-theme-framework" ); ?><br/>
                                <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>"/>
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-thin">
                        <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                            <?php _e( 'Navigation Label', "opal-theme-framework" ); ?><br/>
                            <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>"/>
                        </label>
                    </p>
                    <p class="description description-thin">
                        <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                            <?php _e( 'Title Attribute', "opal-theme-framework" ); ?><br/>
                            <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>"/>
                        </label>
                    </p>
                    <p class="field-link-target description">
                        <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                            <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                            <?php _e( 'Open link in a new window/tab', "opal-theme-framework" ); ?>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                            <?php _e( 'CSS Classes (optional)', "opal-theme-framework" ); ?><br/>
                            <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>"/>
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                            <?php _e( 'Link Relationship (XFN)', "opal-theme-framework" ); ?><br/>
                            <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>"/>
                        </label>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                            <?php _e( 'Description', "opal-theme-framework" ); ?><br/>
                            <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                            <span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.', "opal-theme-framework" ); ?></span>
                        </label>
                    </p>
                    <?php
                    /*
                     * This is the added field
                     */
                    ?>
                    <?php if ($depth == 0){ ?>
                        <?php do_action( 'otf_megamenu_item_config_toplevel', $item, $depth ); ?>
                    <?php } ?>
                    <?php do_action( 'otf_megamenu_item_config', $item, $depth ); ?>

                    <?php
                    /*
                     * end added field
                     */
                    ?>
                    <div class="menu-item-actions description-wide submitbox">
                        <?php if ('custom' != $item->type && $original_title !== false) : ?>
                            <p class="link-to-original">
                                <?php printf( __( 'Original: %s', "opal-theme-framework" ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                        echo wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action'    => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
                            ),
                            'delete-menu_item_' . $item_id
                        ); ?>"><?php _e( 'Remove', "opal-theme-framework" ); ?></a>
                        <span class="meta-sep"> | </span>
                        <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e( 'Cancel', "opal-theme-framework" ); ?></a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>"/>
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>"/>
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>"/>
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>"/>
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>"/>
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>"/>
                    <div class="clearfix"></div>
                </div><!-- .menu-item-settings-->
            </li>
            <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_clean();
        }
    }
}