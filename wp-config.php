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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '1234' );

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
define( 'AUTH_KEY',         ']Xz|=]thQ[1ci--lJv95>KT^vy?%8l!E4EP,8Vq~.m|x-l?;(6<XfBCAU{53>eH]' );
define( 'SECURE_AUTH_KEY',  '4X~1v#NikfZwFQVDB0-{Wv!n@<*AUvTmD`MWXOvJ;d7gt=l,g8^EpuCBgJT4Gz[g' );
define( 'LOGGED_IN_KEY',    'mGyN-2{@5cnzFZZ<|$8FTiJN/7AC$}6uI8%qaOSWQt1U7?+61$KoD,Kw1fM!>>+w' );
define( 'NONCE_KEY',        'f6Zg*|J^a,N`$5a%=.&,zinPBmSDR4jwX+a%5@o$}Du;K3&Pc52`t3T@SfjNp?g>' );
define( 'AUTH_SALT',        'F|WBXU;lV`Lrki&TOrDEY+>]Ij5ll9YX-9x5oSD:_Qwx~XyV2F(buL}OJ9PPY0fA' );
define( 'SECURE_AUTH_SALT', '&CJ0)>XeL9r ?,RtbLP+ TNxsBG!lJO9p^yr|q `,Ca+h;UM`s6Mm#hT2dSveB2L' );
define( 'LOGGED_IN_SALT',   'v@7A?zkSvo-T~u7.kcy+Tg_uw|YfmSLga/Rn3WOb}}qP/>A%-e:_|hNWhu6suoW[' );
define( 'NONCE_SALT',       ']E!RZxog|g?|1`r=X8M(^6&J8MyucMctVB:Gl}|uv+e-?vAseUS]Stg^zaLEz+p6' );

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
