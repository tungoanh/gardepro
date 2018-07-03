<?php
@ini_set( 'upload_max_size' , '64M' );

@ini_set( 'post_max_size', '64M');

@ini_set( 'max_execution_time', '300' );
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require 'inc/back-compat.php';
    return;
}
require 'inc/vendors/tgm/class-tgm-plugin-activation.php';
require 'inc/theme-update-checker.php';

require get_theme_file_path('inc/tgm-plugins.php');

require get_theme_file_path('inc/template-tags.php');
require get_theme_file_path('inc/template-functions.php');

require get_theme_file_path('inc/customizer.php');

require get_theme_file_path('inc/class-main.php');
require get_theme_file_path('inc/extra-functions.php');
require get_theme_file_path('inc/starter-settings.php');

