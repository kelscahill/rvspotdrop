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
define( 'DB_NAME', 'rvspotdropold' );

/** MySQL database username */
define( 'DB_USER', 'root' );

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
define( 'AUTH_KEY',         'h#{ss|?o=%A0^B&3k9#].gc4]Ilu}/t=Fx)dp8:Rp.iW*^bNuvw`P/Dc|SUMkiF/' );
define( 'SECURE_AUTH_KEY',  '.LN>04rv ~2xSF@np+|x%6O_-!9y~No--,@oY;@R81KI7+ikX1M4lbMc{Eky:MZR' );
define( 'LOGGED_IN_KEY',    'jJ{f]j6(0h7F]0rb+L(vLkoWaE-pRrcTdj0D}XDFz6Jfavx,u<~F%#5}5|L]g$AR' );
define( 'NONCE_KEY',        'bl#PF%Upbqq!mOo96;%pC}e.uuiJ$r CEGu$UVuW_c13I)=ibm<?NhLIW[g#m[bY' );
define( 'AUTH_SALT',        '& oUnKm;s HwyT<g7LMMZS8v@N91dn$Jb_VJB=jItIccLEb*oP;OW,>g)]7m/t?U' );
define( 'SECURE_AUTH_SALT', '/iU`_zEw=/p6;o9Q9U+,W:P-q8*,EJjQqn7h[ lnL; MyO`.5cvA6Vk}f<I(I^O$' );
define( 'LOGGED_IN_SALT',   'E`K?R=-toR*y_HB!73bZW]Y>p}N|v8Oh.Hl&/{V.iGcnuq}<DA_ ;4?(mqH-!C(3' );
define( 'NONCE_SALT',       '$|pL-c+?_Hvs^PFr<N4E3M $uW14Z>mXA+2P4q_&5$|8~y9y5iE &W21@X,+q^H^' );

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
