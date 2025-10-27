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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '[~_YN!?2 ;cprBO=J:R,sel,L=U12:)92Q4:Wi;h+2:<FIvKyCkYa?p)u5.qhU+P' );
define( 'SECURE_AUTH_KEY',   'fwvkj>?IyJ4^Rs:M(!Zyfo1i;g8ETr/o8dDx06+dfyn7B#!o^|hVu<<pHz22_pp$' );
define( 'LOGGED_IN_KEY',     '%FJ~ql`oaAG&KSD-/j}_c*JmtFF!w8U;XQkrFfAPAV)GvD)~m-|6FT RYiKkU`wT' );
define( 'NONCE_KEY',         ':+8C%94?aS_)zI&K`omO:^kx}26q>cE|xR<qi-}))Ym+?D^0ORH8g6#oNc7$sKK=' );
define( 'AUTH_SALT',         ' %oZ[$5l9@`LkOaqyQmmU:@7h@tpug8:h6N=m]ELX#D`jpPYI.S?!nr!^x&MAIoG' );
define( 'SECURE_AUTH_SALT',  '@pX=EQ^Rdjya.6 a;.3|ke1+2_jk9(2,>Qs8c?!:dJ73roa:iLHz$h(Ew#JqN~sP' );
define( 'LOGGED_IN_SALT',    'y}%{nNOxH7iYpiic/8T$KJyOCx,|;kSAP1hYO1%vcSPPK8Y&pBlOoH<#(HFaMm@`' );
define( 'NONCE_SALT',        'ri}^k-pAJ7QJlyM;9t?aj36g[G6h?9[yAq@gReb:^3c0`}hwdpmHJtqQn`sc]&.M' );
define( 'WP_CACHE_KEY_SALT', 'rIFn:dK];~5zd1(1k 3F2?_6k|bLGU3Dh*{i/8l1TfP4uN9e4Pd-16:qh1,{@%8&' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'testmultisites.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define('ALLOW_UNFILTERED_UPLOAD', true);
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
