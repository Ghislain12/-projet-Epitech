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
define( 'DB_NAME', 'electron' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'ghislain' );

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
define( 'AUTH_KEY',         '.az|ssJ:BC/8_Q[2nql>~ u4j0CnJ<%@!YH/Ix!`:2EauhlQ&bS5@wK$+X%lmKqH' );
define( 'SECURE_AUTH_KEY',  '!RH2k~z>h#Q,XqlWi:!%_U%iFNvQNViw8bXB.0RJ:zKBk&gavcBQ{7P,a%4{iXAr' );
define( 'LOGGED_IN_KEY',    '|1*e.F(isqUWH#=vP}Sr`9CUZ<#*L{`tw<fhbaSf?g#A_k):MI]8K{SFF$4L<d=Y' );
define( 'NONCE_KEY',        'u)8m1H5Z{kw*hPz(I2Y1VA#lA`7xP>G0xbHSU+kEzp3aGP2 ~?#N,}L_r~dd)N]x' );
define( 'AUTH_SALT',        'q~.N|`8Lj!b_?A2stlxDhLbJ#*cVo9<],{J-Es2FN_zr5%L[:ET9`>oPQS - &{S' );
define( 'SECURE_AUTH_SALT', 'Q#qft6Qie6Q cPE>$UZ:sX)?r`_.9M/=%D-HIi5(]l,m}wx^5F{$w^Ww8{B<G-{p' );
define( 'LOGGED_IN_SALT',   '{WAcCkLT,BW)=z~Wpw5r(5%7eNx4t(ii K|TmykfDbT:~p^$![Vx+nA69x|<EPG]' );
define( 'NONCE_SALT',       'jk]8&hx59,<~/YOE9wpTaXi]/z}Qc#agRGFE3im!4D9uObRF5<m,)4X!f+ Qo5mU' );
define('JWT_AUTH_SECRET_KEY', 'dN[-EFT-WV:6}G0GaZ0mg4_-Z<#$S$V#6:mx+0uiS1X$~|SQLb1R>N;y}W;KV&Cb');
define('JWT_AUTH_CORS_ENABLE', true);

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
