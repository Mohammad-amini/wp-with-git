<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test-wp-cli' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'P|1,a#-|aczgOH/@>kjxtHQMIcHu+Ni$fATvgeYJ,_0D+9h-DFmwscJ3l_pHFiUy' );
define( 'SECURE_AUTH_KEY',  '~WOOeK1CR?c=4SI/`O^H JglYH[C$ZK(HrQ@0CQ~GpfjYG+c_@wn-,o3(KJ_tfi#' );
define( 'LOGGED_IN_KEY',    '<(`I!bh3>YoIB{FoLn_[J9<vFjWn=4sLUziIEKp:mI0&n9yo`8(3B!4lzZmE6T^>' );
define( 'NONCE_KEY',        'c:<lA|d}D33YYU7FP{rt{m)h,4W9m/rbpJ3BwfW3T9!xI9?]z>iXb:%C0,`jM|b ' );
define( 'AUTH_SALT',        'JTG%;[Rn<o|VEiOEXY&x#9[G]A=4kp*@x^G{+q!W2a_LZ(7C:9P=W$&&G#&}vmi#' );
define( 'SECURE_AUTH_SALT', '&N^`G_+w8aT2`kQ6u@14F}wqqUmUhu|P %z,9rpx2Iip@Q^pu2:{d<:5ArWi_%GY' );
define( 'LOGGED_IN_SALT',   'ka9mScV~n^418xs7T[)IK|u083Z):*][%E!k5bmIz*Ilz^id0`_%!8g/3,P1}vZf' );
define( 'NONCE_SALT',       'SqBA<M1}3Ao]wb0~{xt:(Ab^0Uk#bu:IaKsJ>/;n0EbIBa{,8tJBdb)1CDDmz[fq' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_cli_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
require_once ABSPATH . 'functions.php';
