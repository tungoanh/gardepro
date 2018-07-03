<?php
if (!defined( 'ABSPATH' )) {
    exit;
}
if (!class_exists( 'OTF_Customize' )){

class OTF_Customize {
    /**
     * @var array
     */
    private $google_fonts;
    
    /**
     * @var string
     */
    private $link_image;
    
    private $theme_domain;

    public function __construct() {
        add_action( 'customize_register', array( $this, 'customize_register' ) );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize) {
        /**
         * Theme options.
         */
        $this->google_fonts = otf_get_google_fonts();
        $this->link_image   = trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_URL ) . 'assets/images/customize/';
        $this->theme_domain = get_template();

        $this->init_otf_typography( $wp_customize );

        $this->init_otf_colors( $wp_customize );

        $this->init_otf_layout( $wp_customize );

        $this->init_otf_header( $wp_customize );

        $this->init_otf_footer( $wp_customize );

        $this->init_otf_blog( $wp_customize );

        if( otf_is_woocommerce_activated() ){
            $this->init_woocommerce( $wp_customize ); 
        }

        if( otf_is_vc_activated() ){
            $this->init_otf_vc( $wp_customize ); 
        }

        if( otf_is_opalrealestate_activated() ){
            $this->init_ore_property( $wp_customize ); 
        }

        if( otf_is_idx_activated() ){
            $this->init_ore_idx( $wp_customize ); 
        }

        if( otf_is_opalrealestate_activated() ){
            $this->init_otf_author( $wp_customize ); 
        }

        $this->init_otf_mobile( $wp_customize );

        $this->init_otf_animations( $wp_customize );
   
        do_action( 'otf_customize_register', $wp_customize );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_typography($wp_customize){
    
        $wp_customize->add_panel( 'otf_typography', array(
            'title'          => __( 'Typography' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_typography_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_typography_general_body_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_typography_general_body_button_move', array(
                'section' => 'otf_typography_general',
                'buttons'  => array(
                'otf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'otf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Primary Font
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_primary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_primary_font_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Primary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_general_body_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_general_body_font', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_general_body_font', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_secondary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_secondary_font_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Heading Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_general_heading_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_general_heading_font', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_general_heading_font', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Tertiary Font
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_tertiary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_tertiary_font_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Tertiary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_general_tertiary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_general_tertiary_font', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_general_tertiary_font', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Quaternary Font
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_quaternary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_quaternary_font_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Quaternary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_general_quaternary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_general_quaternary_font', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_general_quaternary_font', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Body
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_body_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_body_heading_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Body' ),
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_general_body_font_size', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_general_body_font_size', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '25',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_general_body_line_height', array(
                'default'           => '24',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_general_body_line_height', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => '10',
                'max' => '50',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_general_body_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_general_body_letter_spacing', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Heading
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_general_heading_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_general_heading_heading_title', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Heading' ),
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_general_heading_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_general_heading_font_style', array(
                'section' => 'otf_typography_general',
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_general_heading_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_general_heading_letter_spacing', array(
                'section' => 'otf_typography_general',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_typography_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_typography_page_title_breadcrumb_button_move', array(
                'section' => 'otf_typography_page_title',
                'buttons'  => array(
                'otf_layout_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'otf_colors_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Heading
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_page_title_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_page_title_heading_title', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Heading' ),
            ) ) );
        }

        // =========================================
        // Heading Font Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_page_title_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_page_title_font_style', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Heading Font Style' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_font_style', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_heading_font_size', array(
                'default'           => '24',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_heading_font_size', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Heading Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_heading_font_size', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_heading_line_height', array(
                'default'           => '28',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_heading_line_height', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => '10',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_heading_line_height', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_heading_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_heading_letter_spacing', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Breadcrumb
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_page_title_breadcrumb', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Breadcrumb' ),
            ) ) );
        }

        // =========================================
        // Breadcrumb Font Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_page_title_breadcrumb_font_style', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Breadcrumb Font Style' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_breadcrumb_font_style', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_breadcrumb_font_size', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Breadcrumb Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '50' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_breadcrumb_font_size', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb_heading_line_height', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_breadcrumb_heading_line_height', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_breadcrumb_heading_line_height', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_page_title_breadcrumb_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_page_title_breadcrumb_letter_spacing', array(
                'section' => 'otf_typography_page_title',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_page_title_breadcrumb_letter_spacing', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_typography_mainmenu', array(
            'title'          => __( 'Main Menu' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_mainmenu_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_mainmenu_font_family', array(
                'section' => 'otf_typography_mainmenu',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_mainmenu_font_family', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_mainmenu_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_mainmenu_font_style', array(
                'section' => 'otf_typography_mainmenu',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_mainmenu_font_style', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_mainmenu_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_mainmenu_font_size', array(
                'section' => 'otf_typography_mainmenu',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '40' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_mainmenu_font_size', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_typography_vertical_menu', array(
            'title'          => __( 'Vertical Menu' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_vertical_menu_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_vertical_menu_font_family', array(
                'section' => 'otf_typography_vertical_menu',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_vertical_menu_font_family', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_vertical_menu_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_vertical_menu_font_style', array(
                'section' => 'otf_typography_vertical_menu',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_vertical_menu_font_style', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_vertical_menu_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_vertical_menu_font_size', array(
                'section' => 'otf_typography_vertical_menu',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '40' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_vertical_menu_font_size', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_typography_quotes', array(
            'title'          => __( 'Quotes' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_quotes_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_quotes_font_family', array(
                'section' => 'otf_typography_quotes',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_quotes_font_family', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_quotes_font_style', array(
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_quotes_font_style', array(
                'section' => 'otf_typography_quotes',
            ) ) );
        }

        $wp_customize->add_section( 'otf_typography_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Widget Title
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_sidebar_title_heading', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Widget Title' ),
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_sidebar_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_sidebar_font_style', array(
                'section' => 'otf_typography_sidebar',
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_font_size', array(
                'default'           => '16',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_font_size', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '40',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_letter_spacing', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_letter_spacing', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_padding_top', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_padding_top', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_padding_bottom', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_padding_bottom', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_sidebar_title_padding_bottom', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Margin Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_margin_top', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_margin_top', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Margin Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_sidebar_title_margin_top', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_sidebar_title_margin_bottom', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_sidebar_title_margin_bottom', array(
                'section' => 'otf_typography_sidebar',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_typography_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Widget Title
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_typography_footer_widget_title_heading', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Widget Title' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_footer_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_footer_font_family', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_footer_font_family', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_footer_widget_title_font_style', array(
                'section' => 'otf_typography_footer',
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_font_size', array(
                'default'           => '16',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_font_size', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '40',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_letter_spacing', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_letter_spacing', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_padding_top', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_padding_top', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_padding_bottom', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_padding_bottom', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_footer_widget_title_padding_bottom', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Margin Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_margin_top', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_margin_top', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Margin Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_typography_footer_widget_title_margin_bottom', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_typography_footer_widget_title_margin_bottom', array(
                'section' => 'otf_typography_footer',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_typography_button', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OTF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'otf_typography_button_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Google_Font( $wp_customize, 'otf_typography_button_font_family', array(
                'section' => 'otf_typography_button',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_button_font_family', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'otf_typography_button_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Font_Style( $wp_customize, 'otf_typography_button_font_style', array(
                'section' => 'otf_typography_button',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_typography_button_font_style', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_colors($wp_customize){
    
        $wp_customize->add_panel( 'otf_colors', array(
            'title'          => __( 'Colors' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_colors_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_general_color_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_general_color_heading_label', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Color' ),
                'priority' => 1,
            ) ) );
        }

        // =========================================
        // Primary Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_general_primary', array(
                'default'           => '#0160b4',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_general_primary', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Primary Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_general_primary', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_general_secondary', array(
                'default'           => '#00c484',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_general_secondary', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Secondary Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_general_secondary', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_general_heading', array(
                'default'           => '#111',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_general_heading', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Heading Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_general_heading', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Body Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_general_body', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_general_body', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Body Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_general_body', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_general_border', array(
                'default'           => '#ebebeb',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_general_border', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Border Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_general_border', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color Scheme
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_color_scheme_body', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_color_scheme_body', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Color Scheme' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
            ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_color_scheme_body', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Boxed Background
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_general_body_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_general_body_title', array(
                'section' => 'otf_colors_general',
                'label' => __( 'Boxed Background' ),
                'priority' => 2,
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_colors_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_colors_general_button_move', array(
                'section' => 'otf_colors_general',
                'buttons'  => array(
                'otf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'otf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_colors_header', array(
            'title'          => __( 'Header' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Header Skin
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_colors_header_skin', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_colors_header_skin', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Header Skin' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
                'custom' => __( 'Custom' ),
            ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_header_bg', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_header_bg', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_header_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_header_color', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_header_color', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_header_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Main Menu Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_mainmenu', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_mainmenu', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Main Menu Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_mainmenu', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Topbar Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_topbar_bg', array(
                'default'           => '#ddd',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_topbar_bg', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Topbar Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_topbar_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Topbar Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_topbar_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_topbar_color', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Topbar Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_topbar_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Sticky Skin
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_colors_header_sticky_skin', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_colors_header_sticky_skin', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Sticky Skin' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
                'custom' => __( 'Custom' ),
            ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_header_sticky_bg', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_header_sticky_bg', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_header_sticky_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_header_sticky_color', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_header_sticky_color', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_header_sticky_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Main Menu Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_mainmenu_sticky', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_mainmenu_sticky', array(
                'section' => 'otf_colors_header',
                'label' => __( 'Main Menu Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_mainmenu_sticky', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_colors_header_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_colors_header_button_move', array(
                'section' => 'otf_colors_header',
                'buttons'  => array(
                'otf_header' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_colors_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Background
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_page_title_bg_titlfdfdasfe', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_page_title_bg_titlfdfdasfe', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'Background' ),
            ) ) );
        }

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'otf_colors_page_title_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'otf_colors_page_title_bg_image', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'BG Image' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OTF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'otf_colors_page_title_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Background_Position( $wp_customize, 'otf_colors_page_title_bg_position', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'BG Position' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_colors_page_title_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_colors_page_title_bg_repeat', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'Disable Repeat' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_page_title_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_page_title_bg', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'BG Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_page_title_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_page_title_color_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_page_title_color_title', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'Color' ),
            ) ) );
        }

        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_page_title_heading_color', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_page_title_heading_color', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'Heading Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_page_title_heading_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Text Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_page_title_breadcrumb_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_page_title_breadcrumb_color', array(
                'section' => 'otf_colors_page_title',
                'label' => __( 'Breadcrumb Text Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_page_title_breadcrumb_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_colors_page_title_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_colors_page_title_button_move', array(
                'section' => 'otf_colors_page_title',
                'buttons'  => array(
                'otf_typography_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'otf_layout_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_colors_quotes', array(
            'title'          => __( 'Quotes' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_quotes_color', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_quotes_color', array(
                'section' => 'otf_colors_quotes',
                'label' => __( 'Color' ),
            ) ) );
        }

        // =========================================
        // Background
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_quotes_background', array(
                'default'           => 'rgba(255,255,255,0)',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_quotes_background', array(
                'section' => 'otf_colors_quotes',
                'label' => __( 'Background' ),
            ) ) );
        }

        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_quotes_border', array(
                'default'           => '#eceeef',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_quotes_border', array(
                'section' => 'otf_colors_quotes',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_colors_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Skin
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_colors_footer_skin', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_colors_footer_skin', array(
                'section' => 'otf_colors_footer',
                'label' => __( 'Skin' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
                'custom' => __( 'Custom' ),
            ),
            ) ) );
        }

        // =========================================
        // Footer Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_footer_bg', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_footer_bg', array(
                'section' => 'otf_colors_footer',
                'label' => __( 'Footer Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_footer_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Footer Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_footer_color', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_footer_color', array(
                'section' => 'otf_colors_footer',
                'label' => __( 'Footer Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_footer_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Copyright Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_copyright_bg', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_copyright_bg', array(
                'section' => 'otf_colors_footer',
                'label' => __( 'Copyright Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_copyright_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Copyright Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_copyright_color', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_copyright_color', array(
                'section' => 'otf_colors_footer',
                'label' => __( 'Copyright Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_copyright_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_colors_footer_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_colors_footer_button_move', array(
                'section' => 'otf_colors_footer',
                'buttons'  => array(
                'otf_footer' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_colors_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_sidebar_bg_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_sidebar_bg_color', array(
                'section' => 'otf_colors_sidebar',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_sidebar_bg_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_sidebar_border_color', array(
                'default'           => '#ddd',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_sidebar_border_color', array(
                'section' => 'otf_colors_sidebar',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_sidebar_border_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Title Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_sidebar_title_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_sidebar_title_color', array(
                'section' => 'otf_colors_sidebar',
                'label' => __( 'Title Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_sidebar_title_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_sidebar_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_sidebar_color', array(
                'section' => 'otf_colors_sidebar',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_sidebar_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_colors_buttons', array(
            'title'          => __( 'Buttons' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_colors', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_colors_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_colors_button_move', array(
                'section' => 'otf_colors_buttons',
                'buttons'  => array(
                'otf_layout_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'otf_animations_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Animation',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Enable Custom
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_colors_buttons_enable_custom', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_colors_buttons_enable_custom', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Enable Custom' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_enable_custom', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_title_buttons_primary', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_title_buttons_primary', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Primary Button' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_bg', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_border', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_border', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_color', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_color_outline', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color (outline)' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_color_outline', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_title_buttons_primary_hover', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_title_buttons_primary_hover', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Primary Button Hover' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_hover_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_hover_bg', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_hover_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_hover_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_hover_border', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_hover_border', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_primary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_primary_hover_color', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_primary_hover_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_title_buttons_secondary', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_title_buttons_secondary', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Secondary Button' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_bg', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_border', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_border', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_color', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_color_outline', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color (outline)' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_color_outline', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_colors_title_buttons_secondary_hover', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_colors_title_buttons_secondary_hover', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Secondary Button Hover' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_hover_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_hover_bg', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_hover_bg', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_hover_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_hover_border', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_hover_border', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_colors_buttons_secondary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_colors_buttons_secondary_hover_color', array(
                'section' => 'otf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_colors_buttons_secondary_hover_color', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_layout($wp_customize){
    
        $wp_customize->add_panel( 'otf_layout', array(
            'title'          => __( 'Layout' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_layout_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_layout_general_layout_mode', array(
                'default'           => 'wide',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_layout_general_layout_mode', array(
                'section' => 'otf_layout_general',
                'choices' => array(
                'boxed' => __( 'Boxed' ),
                'wide' => __( 'Wide' ),
            ),
            ) ) );
        }

        // =========================================
        // Boxed Container Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_general_layout_boxed_width', array(
                'default'           => '1170',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_general_layout_boxed_width', array(
                'section' => 'otf_layout_general',
                'label' => __( 'Boxed Container Width' ),
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_general_layout_boxed_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Boxed Offset
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_general_layout_boxed_offset', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_general_layout_boxed_offset', array(
                'section' => 'otf_layout_general',
                'label' => __( 'Boxed Offset' ),
                'choices' => array(
                'min' => '0',
                'max' => '200',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_general_layout_boxed_offset', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Content Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_layout_general_content_width_type', array(
                'default'           => 'px',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_layout_general_content_width_type', array(
                'section' => 'otf_layout_general',
                'label' => __( 'Content Width' ),
                'choices' => array(
                'px' => __( 'px' ),
                '%' => __( '%' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_general_content_width_type', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_general_content_width_px', array(
                'default'           => '1170',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_general_content_width_px', array(
                'section' => 'otf_layout_general',
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_general_content_width_px', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_general_content_width_percent', array(
                'default'           => '100',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_general_content_width_percent', array(
                'section' => 'otf_layout_general',
                'choices' => array(
                'min' => '20',
                'max' => '100',
                'unit' => '%',
            ),
            ) ) );
        }

        // =========================================
        // Gutter Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_general_gutter_width', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_general_gutter_width', array(
                'section' => 'otf_layout_general',
                'label' => __( 'Gutter Width' ),
                'choices' => array(
                'min' => '10',
                'max' => '60',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_general_gutter_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_layout_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_layout_general_button_move', array(
                'section' => 'otf_layout_general',
                'buttons'  => array(
                'otf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'otf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_layout_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Sticky Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_layout_sidebar_is_sticky', array(
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_layout_sidebar_is_sticky', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Enable Sticky Sidebar' ),
            ) ) );
        }

        // =========================================
        // Enable Boxed
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_layout_sidebar_is_boxed', array(
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_layout_sidebar_is_boxed', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Enable Boxed' ),
            ) ) );
        }

        // =========================================
        // Title Outside
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_layout_sidebar_title_outside', array(
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_layout_sidebar_title_outside', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Title Outside' ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_sidebar_padding_bottom', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_sidebar_padding_bottom', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_sidebar_margin_bottom', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_sidebar_margin_bottom', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_layout_sidebar_sidebar_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_layout_sidebar_sidebar_heading_title', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        // =========================================
        // Padding Inside Boxed
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_sidebar_padding_inside_boxed', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_sidebar_padding_inside_boxed', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Padding Inside Boxed' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Border Radius
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_sidebar_sidebar_border_radius', array(
                'default'           => '00',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_sidebar_sidebar_border_radius', array(
                'section' => 'otf_layout_sidebar',
                'label' => __( 'Border Radius' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '20' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_layout_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_layout_page_title_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_layout_page_title_width', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_width', array(
            'selector'        => '#page-title-bar',
            'render_callback' => 'otf_customize_partial_page_title',
        ) );
        
        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'otf_layout_page_title_style', array(
                'default'           => 'top-bottom',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_layout_page_title_style', array(
            'section' => 'otf_layout_page_title',
            'label' => __( 'Style' ),
            'type' => 'select',
            'choices' => array(
                'left-right' => __( 'Left - Right' ),
                'right-left' => __( 'Right - Left' ),
                'top-bottom' => __( 'Top - Bottom' ),
                'top-bottom-center' => __( 'Top - Bottom - Center' ),
                'bottom-top' => __( 'Bottom - Top' ),
                'bottom-top-center' => __( 'Bottom - Top - Center' ),
                'none-right' => __( 'None - Right' ),
                'none-left' => __( 'None - Left' ),
                'none-center' => __( 'None - Center' ),
            ),
        ) );

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_style', array(
            'selector'        => '#page-title-bar',
            'render_callback' => 'otf_customize_partial_page_title',
        ) );
        
        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_page_title_padding_top', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_page_title_padding_top', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_padding_top', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Right
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_page_title_padding_right', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_page_title_padding_right', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Padding Right' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_padding_right', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_page_title_padding_bottom', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_page_title_padding_bottom', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_padding_bottom', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Left
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_page_title_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_page_title_padding_left', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Padding Left' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_padding_left', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Height
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_page_title_height', array(
                'default'           => '90',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_page_title_height', array(
                'section' => 'otf_layout_page_title',
                'label' => __( 'Height' ),
                'choices' => array(
                'min' => __( '30' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_layout_page_title_height', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_layout_page_title_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_layout_page_title_button_move', array(
                'section' => 'otf_layout_page_title',
                'buttons'  => array(
                'otf_typography_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'otf_colors_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_layout_pagination', array(
            'title'          => __( 'Pagination' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Pagination Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_layout_pagination_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_layout_pagination_style', array(
                'section' => 'otf_layout_pagination',
                'label' => __( 'Select Pagination Style' ),
                'choices' => array(
                '1' => esc_url($this->link_image . 'pagination1.jpg'),
                '2' => esc_url($this->link_image . 'pagination2.jpg'),
                '3' => esc_url($this->link_image . 'pagination3.jpg'),
                '4' => esc_url($this->link_image . 'pagination4.jpg'),
                '5' => esc_url($this->link_image . 'pagination5.jpg'),
                '6' => esc_url($this->link_image . 'pagination6.jpg'),
                '7' => esc_url($this->link_image . 'pagination7.jpg'),
                '8' => esc_url($this->link_image . 'pagination8.jpg'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        $wp_customize->add_section( 'otf_layout_buttons', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_layout_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_layout_button_move', array(
                'section' => 'otf_layout_buttons',
                'buttons'  => array(
                'otf_animations_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Animation',
                ),
                'otf_colors_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Border radius
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_layout_buttons_border_radius', array(
                'default'           => '3',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_layout_buttons_border_radius', array(
                'section' => 'otf_layout_buttons',
                'label' => __( 'Border radius' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '50' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'otf_comment_template', array(
            'title'          => __( 'Comment Template' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Comment Skin
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_comment_template_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_comment_template_title', array(
                'section' => 'otf_comment_template',
                'label' => __( 'Comment Skin' ),
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_comment_template_skin', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_comment_template_skin', array(
                'section' => 'otf_comment_template',
                'choices' => array(
                '1' => esc_url($this->link_image . 'comment1.png'),
                '2' => esc_url($this->link_image . 'comment2.png'),
                '3' => esc_url($this->link_image . 'comment3.png'),
                '4' => esc_url($this->link_image . 'comment4.png'),
                '5' => esc_url($this->link_image . 'comment5.png'),
                '6' => esc_url($this->link_image . 'comment6.png'),
                '7' => esc_url($this->link_image . 'comment7.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        // =========================================
        // Comment Form
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_comment_template_form_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_comment_template_form_title', array(
                'section' => 'otf_comment_template',
                'label' => __( 'Comment Form' ),
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_comment_template_form', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_comment_template_form', array(
                'section' => 'otf_comment_template',
                'choices' => array(
                '1' => esc_url($this->link_image . 'comment_form1.png'),
                '2' => esc_url($this->link_image . 'comment_form2.png'),
                '3' => esc_url($this->link_image . 'comment_form3.png'),
                '4' => esc_url($this->link_image . 'comment_form4.png'),
                '5' => esc_url($this->link_image . 'comment_form5.png'),
                '6' => esc_url($this->link_image . 'comment_form6.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        $wp_customize->add_section( 'otf_404_page_setting', array(
            'title'          => __( '404 Page Setting' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Page Setting
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_page_404_page_enable', array(
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_page_404_page_enable', array(
                'section' => 'otf_404_page_setting',
                'label' => __( 'Page Setting' ),
                'choices' => array(
                'default' => __( 'Default' ),
                'custom' => __( 'Customize' ),
            ),
            ) ) );
        }

        // =========================================
        // 404 Page
        // =========================================
            $wp_customize->add_setting( 'otf_page_404_page_custom', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_page_404_page_custom', array(
            'section' => 'otf_404_page_setting',
            'label' => __( '404 Page' ),
            'type' => 'dropdown-pages',
        ) );

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'otf_page_404_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'otf_page_404_bg_image', array(
                'section' => 'otf_404_page_setting',
                'label' => __( 'BG Image' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OTF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'otf_page_404_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Background_Position( $wp_customize, 'otf_page_404_bg_position', array(
                'section' => 'otf_404_page_setting',
                'label' => __( 'BG Position' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_page_404_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_page_404_bg_repeat', array(
                'section' => 'otf_404_page_setting',
                'label' => __( 'Disable Repeat' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_page_404_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_page_404_bg', array(
                'section' => 'otf_404_page_setting',
                'label' => __( 'BG Color' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_header($wp_customize){
    
        $wp_customize->add_section( 'otf_header', array(
            'title'          => __( 'Header' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_header_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_header_button_move', array(
                'section' => 'otf_header',
                'buttons'  => array(
                'otf_colors_header' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'title_tagline' => array(
                    'type'  => 'section',
                    'label' => 'Change Logo',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_header_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_header_layout_side_header_heading', array(
                'section' => 'otf_header',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Enable Header Builder
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_enable_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_enable_builder', array(
                'section' => 'otf_header',
                'label' => __( 'Enable Header Builder' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_enable_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'otf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Header Builder
        // =========================================
        if(class_exists('OTF_Customize_Control_Headers')){
            $wp_customize->add_setting( 'otf_header_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Headers( $wp_customize, 'otf_header_builder', array(
                'section' => 'otf_header',
                'label' => __( 'Header Builder' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'otf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_width', array(
                'section' => 'otf_header',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_width', array(
            'selector'        => '#masthead',
            'render_callback' => 'otf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Enable Cart
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_layout_enable_cart_in_menu', array(
                'default'           => 'true',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_layout_enable_cart_in_menu', array(
                'section' => 'otf_header',
                'label' => __( 'Enable Cart' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_layout_enable_cart_in_menu', array(
            'selector'        => '#masthead',
            'render_callback' => 'otf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Enable Search Form
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_layout_enable_search_form_in_menu', array(
                'default'           => 'true',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_layout_enable_search_form_in_menu', array(
                'section' => 'otf_header',
                'label' => __( 'Enable Search Form' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_layout_enable_search_form_in_menu', array(
            'selector'        => '#masthead',
            'render_callback' => 'otf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Enable Sticky
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_layout_is_sticky', array(
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_layout_is_sticky', array(
                'section' => 'otf_header',
                'label' => __( 'Enable Sticky' ),
            ) ) );
        }

        // =========================================
        // Header Sticky Layout
        // =========================================
            $wp_customize->add_setting( 'otf_header_layout_sticky_layout', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_header_layout_sticky_layout', array(
            'section' => 'otf_header',
            'label' => __( 'Header Sticky Layout' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Style 1' ),
                '2' => __( 'Style 2' ),
                '3' => __( 'Style 3' ),
            ),
        ) );

        // =========================================
        // Sticky Full Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_layout_sticky_full_width', array(
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_layout_sticky_full_width', array(
                'section' => 'otf_header',
                'label' => __( 'Sticky Full Width' ),
            ) ) );
        }

        // =========================================
        // Enable Side Header
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_header_layout_enable_side_header', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_header_layout_enable_side_header', array(
                'section' => 'otf_header',
                'label' => __( 'Enable Side Header' ),
            ) ) );
        }

        // =========================================
        // Side Header Position
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_header_layout_side_header_position', array(
                'default'           => 'left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_header_layout_side_header_position', array(
                'section' => 'otf_header',
                'label' => __( 'Side Header Position' ),
                'choices' => array(
                'left' => __( 'Left' ),
                'right' => __( 'Right' ),
            ),
            ) ) );
        }

        // =========================================
        // Side Header Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_header_layout_side_header_width', array(
                'default'           => '300',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_header_layout_side_header_width', array(
                'section' => 'otf_header',
                'label' => __( 'Side Header Width' ),
                'choices' => array(
                'min' => '250',
                'max' => '400',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_header_layout_side_header_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_footer($wp_customize){
    
        $wp_customize->add_section( 'otf_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_footer_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_footer_button_move', array(
                'section' => 'otf_footer',
                'buttons'  => array(
                'otf_colors_footer' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_footer_title_layout', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_footer_title_layout', array(
                'section' => 'otf_footer',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Footers')){
            $wp_customize->add_setting( 'otf_footer_layout', array(
                'default'           => '0',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Footers( $wp_customize, 'otf_footer_layout', array(
                'section' => 'otf_footer',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_footer_padding_top', array(
                'default'           => '50',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_footer_padding_top', array(
                'section' => 'otf_footer',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Copyright
        // =========================================
        if(class_exists('OTF_Customize_Control_Editor')){
            $wp_customize->add_setting( 'otf_footer_copyright', array(
                'default'           => 'Proudly powered by Wpopal.com',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_editor',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Editor( $wp_customize, 'otf_footer_copyright', array(
                'section' => 'otf_footer',
                'label' => __( 'Copyright' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_footer_copyright', array(
            'selector'        => '.site-info > .container',
            'render_callback' => 'otf_customize_partial_copyright',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_blog($wp_customize){
    
        $wp_customize->add_panel( 'otf_blog', array(
            'title'          => __( 'Blog' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_blog_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_blog', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_blog_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_blog_archive_layout', array(
                'section' => 'otf_blog_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Select Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_blog_archive_style', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_blog_archive_style', array(
                'section' => 'otf_blog_archive',
                'label' => __( 'Select Style' ),
                'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_blog_archive_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_blog_archive_sidebar', array(
                'section' => 'otf_blog_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_blog_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_blog_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_blog_archive_sidebar_width', array(
                'section' => 'otf_blog_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_blog_archive_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_blog_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_blog', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_blog_single_layout_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_blog_single_layout_title', array(
                'section' => 'otf_blog_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_blog_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_blog_single_layout', array(
                'section' => 'otf_blog_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_blog_single_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_blog_single_sidebar', array(
                'section' => 'otf_blog_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_blog_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_blog_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_blog_single_sidebar_width', array(
                'section' => 'otf_blog_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_blog_single_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Post Navigation
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_blog_single_post_navigation_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_blog_single_post_navigation_title', array(
                'section' => 'otf_blog_single',
                'label' => __( 'Post Navigation' ),
            ) ) );
        }

        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_blog_single_navigation', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_blog_single_navigation', array(
                'section' => 'otf_blog_single',
                'choices' => array(
                '1' => esc_url($this->link_image . 'postnavigation1.png'),
                '2' => esc_url($this->link_image . 'postnavigation2.png'),
                '3' => esc_url($this->link_image . 'postnavigation3.png'),
                '4' => esc_url($this->link_image . 'postnavigation4.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_woocommerce($wp_customize){
    
        $wp_customize->add_panel( 'woocommerce', array(
            'title'          => __( 'Woocommerce' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_woocommerce_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_archive_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_archive_layout_heading', array(
                'section' => 'otf_woocommerce_archive',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_woocommerce_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_woocommerce_archive_layout', array(
                'section' => 'otf_woocommerce_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_woocommerce_archive_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_woocommerce_archive_sidebar', array(
                'section' => 'otf_woocommerce_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_woocommerce_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_woocommerce_archive_sidebar_width', array(
                'section' => 'otf_woocommerce_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_archive_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Filter position
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_archive_filter_position', array(
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_archive_filter_position', array(
            'section' => 'otf_woocommerce_archive',
            'label' => __( 'Filter position' ),
            'type' => 'select',
            'choices' => array(
                'top' => __( 'Top' ),
                'left' => __( 'Left' ),
                'right' => __( 'Right' ),
            ),
        ) );

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_archive_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_archive_columns', array(
            'section' => 'otf_woocommerce_archive',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_archive_number', array(
                'default'           => '12',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_archive_number', array(
            'section' => 'otf_woocommerce_archive',
            'label' => __( 'Number product to show' ),
            'type' => 'number',
        ) );

        // =========================================
        // Product Catalog
        // =========================================
        if(otf_woocommerce_version_check() && class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_archive_catalog_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_archive_catalog_heading', array(
                'section' => 'otf_woocommerce_archive',
                'label' => __( 'Product Catalog' ),
                'priority' => 20,
            ) ) );
        }

        $wp_customize->add_section( 'otf_woocommerce_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(otf_woocommerce_version_check() && class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single__image_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Image' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single_layout_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_woocommerce_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_woocommerce_single_layout', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_woocommerce_single_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_woocommerce_single_sidebar', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_woocommerce_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_woocommerce_single_sidebar_width', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_single_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_woocommerce_single_product_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_woocommerce_single_product_width', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_single_product_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_single_product_style', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Style' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Style 1' ),
                '2' => __( 'Style 2' ),
                '3' => __( 'Style 3' ),
                '4' => __( 'Style 4' ),
                '5' => __( 'Style 5' ),
            ),
        ) );

        // =========================================
        // Tab Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_woocommerce_single_product_tab_style', array(
                'default'           => 'tab',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_woocommerce_single_product_tab_style', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Tab Style' ),
                'choices' => array(
                'tab' => __( 'Tab' ),
                'accordion' => __( 'Accordion' ),
            ),
            ) ) );
        }

        // =========================================
        // Product Gallery
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single_image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single_image_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Product Gallery' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_product_thumbnail_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_product_thumbnail_columns', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Upsale
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single_upsale_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single_upsale_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Product Upsale' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_single_upsale_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_single_upsale_columns', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Related
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single_related_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single_related_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Product Related' ),
            ) ) );
        }

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_single_related_number', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_single_related_number', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Number product to show' ),
            'type' => 'number',
        ) );

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_single_related_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_single_related_columns', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Up-sell
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_single_upsell_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_single_upsell_heading', array(
                'section' => 'otf_woocommerce_single',
                'label' => __( 'Product Up-sell' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_single_upsell_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_single_upsell_columns', array(
            'section' => 'otf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        $wp_customize->add_section( 'otf_woocommerce_product', array(
            'title'          => __( 'Product' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(otf_woocommerce_version_check() && class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_archive__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_archive__image_heading', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Image' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_layout_heading', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_product_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_product_style', array(
            'section' => 'otf_woocommerce_product',
            'label' => __( 'Style' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Style 1' ),
                '2' => __( 'Style 2' ),
                '3' => __( 'Style 3' ),
                '4' => __( 'Style 4' ),
                '5' => __( 'Style 5' ),
                '6' => __( 'Style 6' ),
                '7' => __( 'Style 7' ),
                '8' => __( 'Style 8' ),
                '9' => __( 'Style 9' ),
                '10' => __( 'Style 10' ),
                '11' => __( 'Style 11' ),
                '12' => __( 'Style 12' ),
                '13' => __( 'Style 13' ),
                '14' => __( 'Style 14' ),
                '15' => __( 'Style 15' ),
                '16' => __( 'Style 16' ),
            ),
        ) );

        // =========================================
        // Animation Image Hover
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_product_hover', array(
                'default'           => 'none',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_product_hover', array(
            'section' => 'otf_woocommerce_product',
            'label' => __( 'Animation Image Hover' ),
            'type' => 'select',
            'choices' => array(
                'none' => __( 'None' ),
                'bottom-to-top' => __( 'Bottom to Top' ),
                'top-to-bottom' => __( 'Top to Bottom' ),
                'right-to-left' => __( 'Right to Left' ),
                'left-to-right' => __( 'Left to Right' ),
                'swap' => __( 'Swap' ),
                'fade' => __( 'Fade' ),
                'zoom-in' => __( 'Zoom In' ),
                'zoom-out' => __( 'Zoom Out' ),
            ),
        ) );

        // =========================================
        // Enable Box Shadow
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_woocommerce_product_boxshadow_custom_enable', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_woocommerce_product_boxshadow_custom_enable', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Enable Box Shadow' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_boxshadow_custom_enable', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Enable Custom Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_custom_enable', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'otf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Switch( $wp_customize, 'otf_woocommerce_product_color_custom_enable', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Enable Custom Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_custom_enable', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Button Add To Cart
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_heading_add_to_cart', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_color_heading_add_to_cart', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Button Add To Cart' ),
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_add_to_cart', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_add_to_cart', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_add_to_cart', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_add_to_cart', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_add_to_cart', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_add_to_cart', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_add_to_cart', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_add_to_cart', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_add_to_cart', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_add_to_cart_hover', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_add_to_cart_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_add_to_cart_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_add_to_cart_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_add_to_cart_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_add_to_cart_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_add_to_cart_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_add_to_cart_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_add_to_cart_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Button Quick View
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_heading_quick_view', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_color_heading_quick_view', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Button Quick View' ),
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_quick_view', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_quick_view', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_quick_view', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_quick_view', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_quick_view', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_quick_view', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_quick_view', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_quick_view', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_quick_view', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_quick_view_hover', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_quick_view_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_quick_view_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_quick_view_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_quick_view_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_quick_view_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color Hober
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_quick_view_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_quick_view_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color Hober' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_quick_view_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Button Wish List
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_heading_wish_list', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_color_heading_wish_list', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Button Wish List' ),
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_wish_list', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_wish_list', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_wish_list', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_wish_list', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_wish_list', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_wish_list', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_wish_list', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_wish_list', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_wish_list', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_wish_list_hover', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_wish_list_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_wish_list_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_wish_list_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_wish_list_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_wish_list_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_wish_list_hover', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_wish_list_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_wish_list_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Button Compare
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_heading_compare', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_color_heading_compare', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Button Compare' ),
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_compare', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_compare', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_compare', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_compare', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_compare', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_compare', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_compare', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_compare', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_compare', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_compare_hover', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_compare_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_compare_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_compare_hover', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_compare_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_compare_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color Hover
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_compare_hover', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_compare_hover', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_compare_hover', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Label Sale
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_heading_label_sale', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_color_heading_label_sale', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Label Sale' ),
            ) ) );
        }

        // =========================================
        // Shape
        // =========================================
            $wp_customize->add_setting( 'otf_woocommerce_product_label_sale_shape', array(
                'default'           => 'square',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_woocommerce_product_label_sale_shape', array(
            'section' => 'otf_woocommerce_product',
            'label' => __( 'Shape' ),
            'type' => 'select',
            'choices' => array(
                'square' => __( 'Square' ),
                'rounded' => __( 'Rounded' ),
                'circle' => __( 'Circle' ),
                'rotate' => __( 'Rotate' ),
            ),
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_label_sale', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_label_sale', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_label_sale', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Background
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_bg_label_sale', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_bg_label_sale', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Background' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_bg_label_sale', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'otf_woocommerce_product_color_border_label_sale', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'otf_woocommerce_product_color_border_label_sale', array(
                'section' => 'otf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_woocommerce_product_color_border_label_sale', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_vc($wp_customize){
    
        $wp_customize->add_section( 'otf_vc', array(
            'title'          => __( 'Visual Composer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Grid Item
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'ore_vc_Grid_Item_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'ore_vc_Grid_Item_heading_label', array(
                'section' => 'otf_vc',
                'label' => __( 'Grid Item' ),
            ) ) );
        }

        // =========================================
        // Number Words in Post Excerpt
        // =========================================
            $wp_customize->add_setting( 'otf_vc_grid_post_excerpt_number_words', array(
                'default'           => '55',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_vc_grid_post_excerpt_number_words', array(
            'section' => 'otf_vc',
            'label' => __( 'Number Words in Post Excerpt' ),
            'type' => 'text',
        ) );

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_ore_property($wp_customize){
    
        $wp_customize->add_panel( 'ore_property', array(
            'title'          => __( 'Opal Real Estate' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'ore_property_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'ore_property', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'ore_property_archive_layout_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'ore_property_archive_layout_heading_label', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_property_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_property_archive_layout', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_archive_padding_top', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_archive_padding_top', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_archive_padding_top', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_archive_padding_bottom', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_archive_padding_bottom', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_archive_padding_bottom', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_property_archive_sidebar_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_property_archive_sidebar_heading_label', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_property_archive_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_property_archive_sidebar', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_archive_sidebar_width', array(
                'section' => 'ore_property_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => __( '200' ),
                'max' => __( '500' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_archive_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'otf_property_archive_grid_column', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_property_archive_grid_column', array(
            'section' => 'ore_property_archive',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        $wp_customize->add_section( 'ore_property_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'ore_property', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_property_single_layout_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_property_single_layout_heading_label', array(
                'section' => 'ore_property_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_property_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_property_single_layout', array(
                'section' => 'ore_property_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_property_single_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_property_single_style', array(
                'section' => 'ore_property_single',
                'label' => __( 'Style' ),
                'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_single_padding_top', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_single_padding_top', array(
                'section' => 'ore_property_single',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_single_padding_top', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_single_padding_top', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_single_padding_top', array(
                'section' => 'ore_property_single',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_single_padding_top', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_property_single_sidebar_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_property_single_sidebar_heading_label', array(
                'section' => 'ore_property_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_property_single_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_property_single_sidebar', array(
                'section' => 'ore_property_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_property_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_property_single_sidebar_width', array(
                'section' => 'ore_property_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => __( '200' ),
                'max' => __( '500' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_property_single_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'ore_property_colors', array(
            'title'          => __( 'Colors' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'ore_property', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Label
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'ore_property_colors_label_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'ore_property_colors_label_heading', array(
                'section' => 'ore_property_colors',
                'label' => __( 'Label' ),
            ) ) );
        }

        // =========================================
        // BG Hot Offer
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'ore_property_colors_label_hot_offer', array(
                'default'           => '#ff4a5d',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'ore_property_colors_label_hot_offer', array(
                'section' => 'ore_property_colors',
                'label' => __( 'BG Hot Offer' ),
            ) ) );
        }

        // =========================================
        // BG Featured
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'ore_property_colors_label_featured', array(
                'default'           => '#06beda',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'ore_property_colors_label_featured', array(
                'section' => 'ore_property_colors',
                'label' => __( 'BG Featured' ),
            ) ) );
        }

        // =========================================
        // BG Sale - Rent
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'ore_property_colors_label_sale_rent', array(
                'default'           => '#333',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'ore_property_colors_label_sale_rent', array(
                'section' => 'ore_property_colors',
                'label' => __( 'BG Sale - Rent' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_ore_idx($wp_customize){
    
        $wp_customize->add_panel( 'ore_idx', array(
            'title'          => __( 'IDX' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'ore_idx_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'ore_idx', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_idx_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_idx_single_layout', array(
                'section' => 'ore_idx_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_idx_single_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_idx_single_sidebar', array(
                'section' => 'ore_idx_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_idx_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_idx_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_idx_single_sidebar_width', array(
                'section' => 'ore_idx_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'ore_idx_single_color_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'ore_idx_single_color_heading_label', array(
                'section' => 'ore_idx_single',
                'label' => __( 'Color' ),
            ) ) );
        }

        // =========================================
        // BG Page
        // =========================================
        if(class_exists('OTF_Customize_Control_Color')){
            $wp_customize->add_setting( 'ore_idx_single_color_bg_page', array(
                'default'           => 'rgba(0,0,0,0)',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Color( $wp_customize, 'ore_idx_single_color_bg_page', array(
                'section' => 'ore_idx_single',
                'label' => __( 'BG Page' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_author($wp_customize){
    
        $wp_customize->add_panel( 'otf_author', array(
            'title'          => __( 'Author' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_author_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_author', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_author_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_author_archive_layout', array(
                'section' => 'otf_author_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_author_archive_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_author_archive_sidebar', array(
                'section' => 'otf_author_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_author_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_author_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_author_archive_sidebar_width', array(
                'section' => 'otf_author_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => __( '200' ),
                'max' => __( '500' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_author_archive_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_author_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_author', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_author_single_layout_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_author_single_layout_title', array(
                'section' => 'otf_author_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OTF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'otf_author_single_layout', array(
                'default'           => '1c',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_author_single_layout', array(
                'section' => 'otf_author_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OTF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'otf_author_single_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_author_single_sidebar', array(
                'section' => 'otf_author_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_author_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OTF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'otf_author_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Slider( $wp_customize, 'otf_author_single_sidebar_width', array(
                'section' => 'otf_author_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'otf_author_single_sidebar_width', array(
            'selector'        => '#otf-style-inline-css-customizer',
            'render_callback' => 'otf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_mobile($wp_customize){
    
        $wp_customize->add_section( 'otf_mobile', array(
            'title'          => __( 'Mobile' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Effect Canvas Menu
        // =========================================
            $wp_customize->add_setting( 'otf_mobile_effect_menu', array(
                'default'           => '3',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_mobile_effect_menu', array(
            'section' => 'otf_mobile',
            'label' => __( 'Effect Canvas Menu' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Slide in on top' ),
                '3' => __( 'Push' ),
                '4' => __( 'Slide Along' ),
                '6' => __( 'Rotate Pusher' ),
                '7' => __( '3D Rotate In' ),
                '8' => __( '3D Rotate In' ),
                '9' => __( 'Scale Down Pusher' ),
                '10' => __( 'Scale Up' ),
                '11' => __( 'Scale & Rotate Pusher' ),
                '12' => __( 'Open Door' ),
                '13' => __( 'Fall Down' ),
                '14' => __( 'Delayed 3d Rotate' ),
            ),
        ) );

        // =========================================
        // Skin
        // =========================================
        if(class_exists('OTF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'otf_mobile_menu_skin', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Group( $wp_customize, 'otf_mobile_menu_skin', array(
                'section' => 'otf_mobile',
                'label' => __( 'Skin' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
            ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_otf_animations($wp_customize){
    
        $wp_customize->add_panel( 'otf_animations', array(
            'title'          => __( 'Animation' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'otf_animations_buttons', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_animations', 
            'priority'       => 1, 
        ) );

        if(class_exists('OTF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'otf_animations_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Button_Move( $wp_customize, 'otf_animations_button_move', array(
                'section' => 'otf_animations_buttons',
                'buttons'  => array(
                'otf_layout_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'otf_colors_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Background Transitions
        // =========================================
        if(class_exists('OTF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_animations_buttons_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OTF_Customize_Control_Heading( $wp_customize, 'otf_animations_buttons_title', array(
                'section' => 'otf_animations_buttons',
                'label' => __( 'Background Transitions' ),
            ) ) );
        }

        // =========================================
        // Type
        // =========================================
            $wp_customize->add_setting( 'otf_animations_buttons_background', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'otf_animations_buttons_background', array(
            'section' => 'otf_animations_buttons',
            'label' => __( 'Type' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Fade' ),
                '2' => __( 'Back Pulse' ),
                '3' => __( 'Sweep To Right' ),
                '4' => __( 'Sweep To Left' ),
                '5' => __( 'Sweep To Bottom' ),
                '6' => __( 'Sweep To Top' ),
                '7' => __( 'Bounce To Right' ),
                '8' => __( 'Bounce To Left' ),
                '9' => __( 'Bounce To Bottom' ),
                '10' => __( 'Bounce To Top' ),
                '11' => __( 'Radial Out' ),
                '12' => __( 'Radial In' ),
                '13' => __( 'Rectangle In' ),
                '14' => __( 'Rectangle Out' ),
                '15' => __( 'Shutter In Horizontal' ),
                '16' => __( 'Shutter Out Horizontal' ),
                '17' => __( 'Shutter In Vertical' ),
                '18' => __( 'Shutter Out Vertical' ),
            ),
        ) );

    }

}
}
new OTF_Customize();