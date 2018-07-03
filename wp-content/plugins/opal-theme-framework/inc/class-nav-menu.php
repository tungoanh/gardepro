<?php
if (!defined( 'ABSPATH' )){
    exit;
}

if (!class_exists( "OTF_Nav_walker" )){
    class OTF_Nav_walker extends Walker_Nav_Menu {
        private $css_inline;

        /**
         * __construct function.
         *
         * @access public
         * @return void
         */
        public function __construct() {

        }

        /**
         * start_lvl function.
         *
         * @access public
         *
         * @param mixed &$output
         * @param mixed $depth
         *
         * @return void
         */
        public function start_lvl(&$output, $depth = 0, $args = array()) {

            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"sub-menu\">\n";

        }

        /**
         * Ends the list of after the elements are added.
         *
         * @see   Walker::end_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         */
        public function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent</ul>\n";
        }

        /**
         * start_el function.
         *
         * @access public
         *
         * @param mixed &$output
         * @param mixed $item
         * @param int   $depth (default: 0)
         * @param array $args  (default: array())
         * @param int   $id    (default: 0)
         *
         * @return void
         */
        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $li_attributes = ' data-level="' . esc_attr( $depth ) . '"';

            $class_names = $value = '';


            $classes   = empty( $item->classes ) ? array() : (array)$item->classes;
            $classes[] = ( !empty($args->has_children) ) ? 'dropdown' : '';
            $classes[] = ( $item->current || $item->current_item_ancestor ) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'level-' . $depth;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            $megacontent = '';
            if ($this->hasMega( $item, $depth )){
                $megacontent = $this->genMegaMenuByConfig( $item, $depth );
                $class_names .= ' aligned-' . $item->alignment;
                $class_names .= ' menu-item-has-children';

                $args->has_children = true;
            }

            $class_names = ' class="megamenu-item ' . esc_attr( $class_names ) . '"';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
            $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

            $attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
            $attributes .= !empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
            $attributes .= !empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
            $attributes .= !empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';

            $hascaret = $this->hasMega( $item, $depth );


            $text_customize = $menu_icon = '';
            if (isset( $item->text_customize ) && !empty( $item->text_customize )){
                switch ($item->text_customize) {
                    case 'text_new':
                        $text_customize = esc_html__( 'New', 'opal-theme-framework' );
                        break;
                    case 'text_hot':
                        $text_customize = esc_html__( 'Hot', 'opal-theme-framework' );
                        break;
                    case 'text_featured':
                        $text_customize = esc_html__( 'Featured', 'opal-theme-framework' );
                        break;
                    default:
                        $text_customize = '';
                        break;
                }
                $text_customize = !empty( $item->text_customize ) ? '<span class="text-label ' . str_replace( '_', '-', $item->text_customize ) . '">' . $text_customize . '</span>' : '';
            }

            if( isset($item->icon) && !empty($item->icon)){
                $menu_icon = '<span class="'.esc_attr($item->icon).'"></span>';
            }


            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $menu_icon;
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= $text_customize;
            $item_output .= ( $args->has_children ) || $hascaret ? ' <i class="fa fa-angle-down"></i></a><button type="button" class="dropdown-toggle"><i class="fa fa-angle-down"></i></button>' : '</a>';
            $item_output .= $args->after;


            $item_output .= $megacontent;


            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * display_element function.
         *
         * @access public
         *
         * @param mixed $element
         * @param mixed &$children_elements
         * @param mixed $max_depth
         * @param int   $depth (default: 0)
         * @param mixed $args
         * @param mixed &$output
         *
         * @return void
         */
        public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
            if (!$element){
                return;
            }
            $id_field = $this->db_fields['id'];

            if ($this->hasMega( $element, $depth )){
                $children_elements[$element->$id_field] = array();
            }

            if (is_array( $args[0] )){
                $args[0]['has_children'] = !empty( $children_elements[$element->$id_field] );
            } else{
                if (is_object( $args[0] )){
                    $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
                }
            }
            $cb_args = array_merge( array( &$output, $element, $depth ), $args );
            call_user_func_array( array( &$this, 'start_el' ), $cb_args );
            $id = $element->$id_field;
            if (( $max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[$id] )){

                foreach ($children_elements[$id] as $child) {

                    if (!isset( $newlevel )){
                        $newlevel = true;
                        $cb_args  = array_merge( array( &$output, $depth ), $args );
                        call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
                    }
                    $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
                }
                unset( $children_elements[$id] );
            }

            if (isset( $newlevel ) && $newlevel){
                $cb_args = array_merge( array( &$output, $depth ), $args );
                call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
            }

            $cb_args = array_merge( array( &$output, $element, $depth ), $args );
            call_user_func_array( array( &$this, 'end_el' ), $cb_args );
        }

        public function hasMega($item, $depth) {
            return isset( $item->megamenu ) && $item->megamenu;
        }

        public function genMegaMenuByConfig($item, $depth) {
            $post    = get_post( $item->megamenu );
            $content = apply_filters( 'the_content', $post->post_content );

            $this->add_css( $post->ID );

            $width = $el_class = '';

            if ($item->alignment !== 'fullwidth'){
                $width = $item->width ? 'style="width:' . $item->width . 'px"' : "";
            } else{
                $el_class .= ' submenu-fullwidth w-100';
            }

            return '<ul class="sub-menu megamenu' . $el_class . '" ' . $width . '><li><div class="sub-menu-inner">' . $content . '</div></li></ul>';
        }

        private function add_css($megamenuId) {
            global $megamenu_css;
            $menu_css = get_post_meta( $megamenuId, '_wpb_shortcodes_custom_css', true );
            if ($menu_css){
                $megamenu_css .= $menu_css;
            }
        }
    }
}

