<?php
/**
 * Plugin Name: WooCommerce Paybox Payment plugin
 * Description: Paybox gateway payment plugins for WooCommerce
 * Version: 0.9.8.3
 * Author: Paybox Verifone
 * Author URI: http://www.paybox.com
 * 
 * @package WordPress
 * @since 0.9.0
 */
// Ensure not called directly
if (!defined('ABSPATH')) {
	exit;
}

function isWoocommerceActive(){
	$wooCommerceActive = (in_array('woocommerce/woocommerce.php',apply_filters('active_plugins', get_option('active_plugins'))));
	if(is_multisite()){
		//Si multisite
		$wooCommerceActive = (array_key_exists('woocommerce/woocommerce.php', 
														apply_filters('active_plugins', get_site_option('active_sitewide_plugins'))));
	}
	return $wooCommerceActive;
}

// Ensure WooCommerce is active
if (!isWoocommerceActive()) {
	return;
}

define('WC_PAYBOX_PLUGIN', 'woocommerce-paybox');
define('WC_PAYBOX_VERSION', '0.9.8.3');
define('WC_PAYBOX_KEY_PATH', ABSPATH . '/kek.php');


function woocommerce_paybox_installation() {
	global $wpdb;
	$installed_ver = get_option( "WC_PAYBOX_PLUGIN.'_version'" );
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(!isWoocommerceActive()) {
		_e('WooCommerce must be activated', WC_PAYBOX_PLUGIN);
		die();
	}

	if ( $installed_ver != WC_PAYBOX_VERSION ) {
		$tableName = $wpdb->prefix.'wc_paybox_payment';
		$sql = "CREATE TABLE $tableName (
			 id int not null auto_increment,
			 order_id bigint not null,
			 type enum('capture', 'first_payment', 'second_payment', 'third_payment') not null,
			 data varchar(2048) not null,
			 KEY order_id (order_id),
			 PRIMARY KEY  (id))";

		require_once(ABSPATH.'wp-admin/includes/upgrade.php');

		dbDelta( $sql );

		update_option(WC_PAYBOX_PLUGIN.'_version', WC_PAYBOX_VERSION);
	}
	
}
function woocommerce_paybox_initialization() {
	$class = 'WC_Paybox_Abstract_Gateway';

	if (!class_exists($class)) {
		require_once(dirname(__FILE__).'/class/wc-paybox-config.php');
		require_once(dirname(__FILE__).'/class/wc-paybox-iso4217currency.php');
		require_once(dirname(__FILE__).'/class/wc-paybox.php');
		require_once(dirname(__FILE__).'/class/wc-paybox-abstract-gateway.php');
		require_once(dirname(__FILE__).'/class/wc-paybox-standard-gateway.php');
		require_once(dirname(__FILE__).'/class/wc-paybox-threetime-gateway.php');
		require_once(dirname(__FILE__).'/class/wc-paybox-encrypt.php');
	}

	load_plugin_textdomain(WC_PAYBOX_PLUGIN, false, dirname(plugin_basename(__FILE__)).'/lang/');

	$crypto = new PayboxEncrypt();
	if(!file_exists(WC_PAYBOX_KEY_PATH))$crypto->generateKey();
	
    if ( get_site_option( WC_PAYBOX_PLUGIN.'_version' ) != WC_PAYBOX_VERSION ) {
        woocommerce_paybox_installation();
    }
}

function woocommerce_paybox_register(array $methods) {
	$methods[] = 'WC_Paybox_Standard_Gateway';
	$methods[] = 'WC_Paybox_Threetime_Gateway';
	return $methods;
}

register_activation_hook(__FILE__, 'woocommerce_paybox_installation');
add_action('plugins_loaded', 'woocommerce_paybox_initialization');
add_filter('woocommerce_payment_gateways', 'woocommerce_paybox_register');

function woocommerce_paybox_show_details(WC_Order $order) {
	$method = get_post_meta($order->get_id(), '_payment_method', true);
	switch ($method) {
		case 'paybox_std':
			$method = new WC_Paybox_Standard_Gateway();
			$method->showDetails($order);
			break;
		case 'paybox_3x':
			$method = new WC_Paybox_Threetime_Gateway();
			$method->showDetails($order);
			break;
	}
}

add_action('woocommerce_admin_order_data_after_billing_address', 'woocommerce_paybox_show_details');
