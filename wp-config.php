<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
    include( dirname( __FILE__ ) . '/local-config.php' );
}
else {

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'agency_secretsessions');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o*$(i~;<Wb2E[jmEcY) _k<wKx!>rn^kmG9myCt=hb#,=}c6[(N0HUh1VdYf+K1-');
define('SECURE_AUTH_KEY',  'D2BDvT<q]XYyBB=,!d7]SioC4w&|(x05Ur$orzsXeYoy8A%WJ_tsW]*:A4Qan[FG');
define('LOGGED_IN_KEY',    'sc2+{AYE&kZEGF9q:KAGio~>eK=*WsH(z9sSqtOLaY*_mLa2a|/}9^@zQ pf{G_(');
define('NONCE_KEY',        'i]bRH/GY|a{87YyA6lL)p^yF(Y[fasVVH|${?R-GZL~``gu14kRD+$4pjhfgGY}n');
define('AUTH_SALT',        'KF1~7ehOD_.W# T++2P3.$LFOJI;aq7W0qwkh5N)$#f4E@A0H0D$_*2huXKy~Q^;');
define('SECURE_AUTH_SALT', '|LfR:Ra}-Bs0#!=Wvw 1E|E$psZ$H?[R`d$uomJ 4eh./g6a>Cu>4NZgK|-W3wM~');
define('LOGGED_IN_SALT',   '`sn40pLnT>`+[<V|(pTBOO%P^.)vD3:qj$d<Wf+?w|O>u4W7nYxr3EjBmE,c9^#5');
define('NONCE_SALT',       '*6Xy!--]}w1rZ|BOj),s{2)S4_A;Z8*b7=.nqe-x}fzs8H*irefo!YlVENZW$O`Q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
