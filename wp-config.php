<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gardepro_dev_fuznet_com');

/** MySQL database username */
define('DB_USER', 'gardepro.dev.fuz');

/** MySQL database password */
define('DB_PASSWORD', 'tfha7cGSnNWcpG4Y');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6CO:Hj(nS%4]*!!!Jg+O#skwRf51@ -#@B,Z?m=?I>~4m4,R|b7k`likjST*xZ!W');
define('SECURE_AUTH_KEY',  '?v,8Rx>Iee*u =ibQ63p-RiaKs/ L$YX(/4<Z6v0O;1X%~An)b/!bOHZG&]g Ir(');
define('LOGGED_IN_KEY',    'q#~n4.HXJY&vv~w8E|}?pRQ=zj`H&t`v)`xiS`vS l4{_EW{cW^*aVcN~`)2qp18');
define('NONCE_KEY',        ' :A,>;@>9GIrz.NBFit:z!E&FKaUs;C{EzI8EQ9J&+EpUTZi@mic:]9XXaYET|;I');
define('AUTH_SALT',        'n!c&?*#Tc}EBoQcXwAB*Gh(lzq_aM5[U<f]dA42({G0C^bTr1x`5hbv.{m o9* M');
define('SECURE_AUTH_SALT', '8ur0GCh{u(^1)[qU6x.0US$qQ5LHUkqK~4vUZ%h/x9hqs[DjACtD$,n9<pD9[;Kg');
define('LOGGED_IN_SALT',   '4.D[#ZWt2[0B8hX76wdR4Z>s[?D{20PmDu{{[:?X?>W!0KoUkE!_`tx$!l-~o~)d');
define('NONCE_SALT',       '`w|5_^B^t|Sf71s>M5kVyDWqFQ~HszcPV/h6m;AriZ]{1?`e12?TB;O73Xg,TRUT');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
ini_set('display_errors', 1);
define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
