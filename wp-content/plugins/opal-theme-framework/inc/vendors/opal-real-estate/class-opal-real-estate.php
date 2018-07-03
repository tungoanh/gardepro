<?php

/**
 * Class OTF_Opal_Real_Estate
 */
class OTF_Opal_Real_Estate {
    public function __construct() {
        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_filter( 'opal_theme_sidebar', array( $this, 'init_sidebar' ), 20 );

        add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );

        add_filter( 'otf_customize_layout_page', array( $this, 'set_layout_customize' ), 20 );
        add_filter( 'otf_customize_sidebar_width', array( $this, 'set_sidebar_width_customize' ) );

        add_filter( 'ore_loop_columns_property', array( $this, 'set_property_grid_columns' ) );

        add_action('widgets_init', array($this, 'widgets_init'));
    }

    public function widgets_init(){
        register_sidebar( array(
            'name'          => __( 'Archive Real Estate Sidebar', 'opal-theme-framework' ),
            'id'            => 'sidebar-estate',
            'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'opal-theme-framework' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => __( 'Detail Real Estate Sidebar', 'opal-theme-framework' ),
            'id'            => 'sidebar-estate-detail',
            'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'opal-theme-framework' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }

    /**
     * @param $columns integer
     *
     * @return integer
     */
    public function set_property_grid_columns($columns) {
        return get_theme_mod( 'otf_property_archive_grid_column', 3 );
    }

    public function set_layout_customize($layout) {
        if (ore_is_author()){
            $layout = get_theme_mod( 'otf_author_single_layout', '1c' );
        } elseif (ore_is_author_archive()){
            $layout = get_theme_mod( 'otf_author_archive_layout', '2cr' );
        }elseif(ore_is_property()){
            $layout = get_theme_mod( 'otf_property_single_layout', '2cr' );
        }elseif (ore_is_property_archive()){
            $layout = get_theme_mod( 'otf_property_archive_layout', '2cr' );
        }
        return $layout;
    }

    public function set_sidebar_width_customize($width) {
//        die(get_theme_mod( 'otf_author_archive_sidebar_width', 320 ));
        if (ore_is_author()){
            $width = get_theme_mod( 'otf_author_single_sidebar_width', 320 );
        } elseif (ore_is_author_archive()){
            $width = get_theme_mod( 'otf_author_archive_sidebar_width', 320 );
        }elseif(ore_is_property()){
            $width = get_theme_mod( 'otf_property_single_sidebar_width', 320 );
        }elseif (ore_is_property_archive()){
            $width = get_theme_mod( 'otf_property_archive_sidebar_width', 320 );
        }
        return $width;
    }

    public function add_scripts() {
        if (ore_is_property()){
            wp_enqueue_script( 'otf-property-tabs', trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_URL ) . 'assets/js/realestate-property-tab.js', false, false, true );
        }
    }

    /**
     * @param $sidebar
     *
     * @return string
     */
    public function init_sidebar($sidebar) {
        if (ore_is_property()){
            if (get_theme_mod( 'otf_property_single_layout', '2cr' ) == '1c'){
                $sidebar = '';
            } else{
                $sidebar = get_theme_mod( 'otf_property_single_sidebar', '' );
            }
        }elseif(ore_is_property_archive()){
            if (get_theme_mod( 'otf_property_archive_layout', '2cr' ) == '1c'){
                $sidebar = '';
            } else{
                $sidebar = get_theme_mod( 'otf_property_archive_sidebar', '' );
            }
        } elseif (ore_is_author_archive()){
            if (get_theme_mod( 'otf_author_archive_layout', '2cr' ) == '1c'){
                $sidebar = '';
            } else{
                $sidebar = get_theme_mod( 'otf_author_archive_sidebar', '' );
            }
        } elseif (ore_is_author()){
            if (get_theme_mod( 'otf_author_single_layout', '1c' ) == '1c'){
                $sidebar = '';
            } else{
                $sidebar = get_theme_mod( 'otf_author_single_sidebar', '' );
            }
        }

        return $sidebar;
    }

    /**
     * @param $classes
     *
     * @return array
     */
    public function body_class($classes) {
        $classes[] = 'property-style-' . get_theme_mod( 'otf_property_single_style', 1 );
        if(ore_is_author()){
            $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
            $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_author_single_layout', '1c' );
        }elseif (ore_is_author_archive()){
            $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
            $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_author_archive_layout', '2cr' );
        }elseif(ore_is_property()){
            $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
            $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_property_single_layout', '2cr' );
        }elseif(ore_is_property_archive()){
            $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
            $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_property_archive_layout', '2cr' );
        }
        return $classes;
    }
}

new OTF_Opal_Real_Estate();