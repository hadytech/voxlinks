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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wioBase' );

/** MySQL database username */
define( 'DB_USER', 'wioAdmin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '&u,E[.;y;N<tsm631XV.c1tm_rH~]nLUep5S| dS;/sJ/(=&fN(-A -azOslo2<$' );
define( 'SECURE_AUTH_KEY',  '>D_l2Y[CwG9aGl&Re3!_uuVHB(|xjw*%o6z?iq,vPAi,u|CYDv.*^=:>_eH:wJ^T' );
define( 'LOGGED_IN_KEY',    '@~&Mnh&N74&!rhhmv/`#~0C7o+mC4}%ik}WeLASPff6e[@/12#B]<P3Zp$2N2ow_' );
define( 'NONCE_KEY',        'k`NG7W/hO8pu8y?X4aDqX.ByI<ixi:!R9Ei#RO>)9fCJ%4rDd=<961VyqAF$N!8a' );
define( 'AUTH_SALT',        'M,1U_T8x%|jO#_vB}}r2ilCBQRe@1T!`,1d4t$L_NPT$w88N:*.:?dcYiOD>}2(!' );
define( 'SECURE_AUTH_SALT', 'H9%W*jppm8)/$[LDl~,:j Rjia:mH-~;lW$+Q1%-/@|7u4Q!!ETU XtI1ym^3;zK' );
define( 'LOGGED_IN_SALT',   'r5u[vO^>.XMRXyM({lz8x.|N+DAzy/Tz/-m=^:v?OsBSFxiA`We d[YbrTtt!&+(' );
define( 'NONCE_SALT',       '-|>CiM#cKDOu?=3(4vahV3qYU(w2J5)`0uCWWO)Siqw@uS{nPTl9*>VC^12B$S8.' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
