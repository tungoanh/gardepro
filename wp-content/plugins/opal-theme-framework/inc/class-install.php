<?php

class OTF_Install {
    public static function install() {
        do_action( 'otf_before_install' );

        

        do_action( 'otf_installed' );
    }
}