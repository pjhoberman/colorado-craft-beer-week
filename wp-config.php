<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ccbw');

/** MySQL database username */
define('DB_USER', 'coloradocraftbee');

/** MySQL database password */
define('DB_PASSWORD', 'pL6uxcYp');

/** MySQL hostname */
define('DB_HOST', 'db.coloradocraftbeerweek.com');

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
define('AUTH_KEY',         '}Pis2[.r*AMZfCqsPwS4-5Yf#M5O0<4x k=cAgmm.C]}YPB.L@+X>n~u28)%Ect6');
define('SECURE_AUTH_KEY',  '9]Z-&TzD>_8NNgv8/mzwn}x+wtLPa_{(.%SA2>LJKA@C_@w-o=[;d&.$;9}[wF`k');
define('LOGGED_IN_KEY',    'mAvmA-9--WG6:^yRm+vj^gKrfQ}*|V~M&r>X3ew(RLJLEr0>/) FtzJy{EybXF)u');
define('NONCE_KEY',        '@&q%(15TP4l`x*4B}yN$TcQ#xjzW5X+?IG2z.3o,R4beKZFS=jeJX6*$++e*fM^1');
define('AUTH_SALT',        'ldY^*LI}g0r;F]ia+$7nUqZ&vCO$HJY *E&B5<bp[I qydaGqIpNsxs- ;>Cj%y{');
define('SECURE_AUTH_SALT', 'rz?Gc=#sp0oIOH>CNr|S2vKP<FjaKp2FliDq|zsZDe{ lC@LCU>ecU0@GAcO-c[#');
define('LOGGED_IN_SALT',   'z3lKz|39TT_`$q#G+53 -)Ok{Gk|m2r/n:{N |Pq#(JQrmX1u:{Aoy|L-c!nmAKv');
define('NONCE_SALT',       'uve-uB<`I7mXU1#iDa2M(=^+:w3,+Vm#uXALx^jClHrCy-]!~94NkZpv7-@Bf=|B');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
