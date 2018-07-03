<?php
add_action( 'after_switch_theme', 'ezboozt_starter_settings' );
function ezboozt_starter_settings() {
    if (!get_theme_mod( 'otf_starter_settings', false )){
        $content = wp_remote_fopen( get_theme_file_uri( 'assets/data/customizer.dat' ) );
        if ($content){
            $content = unserialize( $content );
            if (isset( $content['mods'] )){
                foreach ($content['mods'] as $key => $mod) {
                    if (substr( $key, 0, 4 ) !== 'otf_' || $key === 'otf_dev_mode'){
                        continue;
                    }
                    set_theme_mod( $key, $mod );
                }
            }
        }
        set_theme_mod( 'otf_blog_archive_style', 1 );
        set_theme_mod( 'otf_starter_settings', true );
    }
}