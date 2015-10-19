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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'secret-sessions');

/** MySQL database username */
define('DB_USER', 'secret-sessions');

/** MySQL database password */
define('DB_PASSWORD', 'w9BPhVe6');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'qTQy+=1XZ$S+Q^jR*e)kI#68_:^.@k7+AK C6A+B)yMFuKdVGpqyE^O{heUb*_-3');
define('SECURE_AUTH_KEY',  'u6|iogYHilc!0V*fJ2)=QJ#U8J$r~_U+6@Vhs?lZ&2JHe}-:eb||iV/C)Y2kmGPP');
define('LOGGED_IN_KEY',    'ZP[;YdJ;Duykg$}7+t(-y*@SsgLP]EGfd~Q[xM3?q-NW5xPuSD(8:W.pPit7l4?O');
define('NONCE_KEY',        'k-21jEEg)(w@]simXAz,TiDJ34&}5|1v%?JM[8ecs]jLxGPa6qm`|E]h/^kCr7s&');
define('AUTH_SALT',        'f(.+K{feq3eDv3+B~[i5}aDWS{!p,ikQ+pZR6}1kl!Ka!3]V+,Jk0?@z +j+2Be-');
define('SECURE_AUTH_SALT', 'PM$7z>yIX`a%XUs/~qQu|VB6%k)hBPet]:IXUP+aN41#F#u0M62QJ9Yz1?,~_B!#');
define('LOGGED_IN_SALT',   'Lc<.K6A-FyD jq6=`4u35FD>*A8{3HZT;w^o-GNs|-3AGw5WV]Bsjmr~-5.)D^{z');
define('NONCE_SALT',       '+ju$||pIzU+tM#Xm{x=?*q1e{B@Rkn0iB^2D.]01Kk0XGIUN.drm|73<o(4Re;c-');

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
