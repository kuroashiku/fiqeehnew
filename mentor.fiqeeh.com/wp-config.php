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
 
 //---------- akrev
 
define( 'WP_DEBUG', false );
define( 'WP_MEMORY_LIMIT', '256M' );
define('CONCATENATE_SCRIPTS', false);
define('SCRIPT_DEBUG', true);
// Log errors to a debug.log file (optional)
define( 'WP_DEBUG_LOG', true );

// Display errors on screen (for development ONLY)
define( 'WP_DEBUG_DISPLAY', true );

// Disable caching for debugging
define( 'WP_CACHE', false );


//define('FORCE_SSL_ADMIN', true);

//if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && //$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    //$_SERVER['HTTPS'] = 'on';
//}


//-------------- akrev

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rdrood_prodmentor' );
/** Database username */
define( 'DB_USER', 'rdrood_prodmentor' );
/** Database password */
define( 'DB_PASSWORD', 'rd123prod987_Fiq' );
/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );
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
define('AUTH_KEY', '3yuI0%5PNtt9*5gm&:v@xNRm8!4988&OH]M]+53o~9p1Z(y9iR%Fe57F0mR0Kd[*');
define('SECURE_AUTH_KEY', '5g*IS)36IUL(5O~dM)i1v%%O4:0n1ku|d80Pzz*f!Sk(](9:YFB;+HPJagI+0jV0');
define('LOGGED_IN_KEY', 'bnL2(94Csd-1dwieh)gb9//j#uB8_z85iCI~1W#~LK7[YXn641:Q6qTjWF@Ry#2H');
define('NONCE_KEY', '1t%79vnqhU2;Ip5:/[zSA1/80i/8Q!/!4j650~g1B%/B1X27T0BXj6Xl8T9!Zd16');
define('AUTH_SALT', '9)~fn2C#apN;6tSaT:l1)Rn;2EWsII_@X#1-;#TH+8Brza68B06+T4p6+nd[lP!v');
define('SECURE_AUTH_SALT', 'n%c7cT3DPmR*t+#94K4X%c80M982Rk|F&(_d:zC(2p!#/1-I~rU5ghn2M005)by)');
define('LOGGED_IN_SALT', 'X-mRu!&Q#74f6u(9/wKcL2*GM*GnTV:Z+N%5jfWjCCF*]@|OmR0[]308R0;_H0ja');
define('NONCE_SALT', '-vDO5H~:5[28!)5+8g62B-[*Zi45Er+5z~4O#fV#[zCY2s%7KT;wDv~#C6Leds65');
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'vOsfK_';
/* Add any custom values between this line and the "stop editing" line. */
define('WP_ALLOW_MULTISITE', true);
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
define( 'DISABLE_WP_CRON', true );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
