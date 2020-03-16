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
define( 'DB_NAME', 'default' );

/** MySQL database username */
define( 'DB_USER', 'default' );

/** MySQL database password */
define( 'DB_PASSWORD', 'secret' );

/** MySQL hostname */
define( 'DB_HOST', 'mariadb' );

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
define( 'AUTH_KEY',         'I*eT.J*${(Y@6AlmN9k!Np+v{Uxpu]A4$L4Z/4M^EW`>94L6^A;F>6qoj2E,2^3.' );
define( 'SECURE_AUTH_KEY',  'peFk^4cd`$#08EO6[L (2ZEnM*OvtHv<*/r1OBO ZbH[k8;1CV>jbZiN4R.iQ@Yr' );
define( 'LOGGED_IN_KEY',    '_<J2/kk+&&VnS24)psrP!]?U5$A.p&|*Xs1L-H#~tHw$oO]j8j|=PVwta1+/!X`(' );
define( 'NONCE_KEY',        'd|$omTeJ%9GZF:m) !-Ef$PX!ce..q)$P4OVFRC&:#744z4(krXrQ{p8m*`*=nPx' );
define( 'AUTH_SALT',        '~Xf)yG:wlWL=b%Y%D+!n-%w0YS1R}Z=CL9XOR@*&#3Q;Zsy2m<1#l/.: aE)w;05' );
define( 'SECURE_AUTH_SALT', 'xS#2xKeXK# X~|8ouvK)|q{;ma`pu#39-MtAe;>D.bAt1I0..E<*+MBzYoVz$/EL' );
define( 'LOGGED_IN_SALT',   'xBj8iHu>9M.*IIa3IMU#yLK[lW(MO`u K(ok?)[7@T9B:=!h [lVDT];Bgv4XCE`' );
define( 'NONCE_SALT',       '_C/1E%iqkTnmt3Y661cTwgivq}FPO!eR|KuXXDv mS:qOGD3=xk<>sJ.> C[y-IO' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
