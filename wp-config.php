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
define( 'DB_NAME', 'store' );

/** MySQL database username */
define( 'DB_USER', 'store' );

/** MySQL database password */
define( 'DB_PASSWORD', 'store' );

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
define( 'AUTH_KEY',         '0-MnOfk9h2Mh6A1?KRBHQxFvKD3TzqUS+~#Sq5nX(WIIJA:V+l#0x#^xydwsBi`+' );
define( 'SECURE_AUTH_KEY',  'r#vV2A(R8i%s3nOv;wP 4{gXW%m}W9!29Q^H9mov_x%rIi!%tYCJvv!$ixH,h-Je' );
define( 'LOGGED_IN_KEY',    'k[FuA+Cp,<}X|C!<Z(:s^a_9Tu8<8IGpzD@ 4(=T_so4,|8W !_6M|}xse,BnIb>' );
define( 'NONCE_KEY',        'Mu-B)|tY61N#`gYJRnoCx+N(EG4roa GJ5EzQjXIw`:{b4GagL$`zVHQlIR;4}A5' );
define( 'AUTH_SALT',        'q+?E>YtWYk*VI1u; >Aim]e<I_my4lS%v]2+%u*ha?/R}o}4d,eC{HN.8b[ LGoZ' );
define( 'SECURE_AUTH_SALT', '=s9G~OfLWa@V 24jtfAf]pmD|}sm 32!#7e]pX+}jY[E^QQ!OJ]qbr`tEGu5eDjl' );
define( 'LOGGED_IN_SALT',   'iHy?yLCQ39h ,EKP<EXC4 Tg3(9w_5X8<Nc]X|y4ceKu2M4$RqcL#xg4,m{1Tcd$' );
define( 'NONCE_SALT',       '$<`;A|+2(w(2H2MjEKo$9$pCSS4:>sA&8@RAx(>^3W-w*|?dO&#VORrEiU-88gbQ' );

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
