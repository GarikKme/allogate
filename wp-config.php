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
define( 'DB_NAME', 'allogate' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '0C2i(o|.>*@tj;EM2UUsM1y;N0(|d~0T#~N67Y?%=p>J17z.fCMVw_nt3-}+xrzn' );
define( 'SECURE_AUTH_KEY',  'eWWF[o81{ng_P,ZF)Y!<!Y=XjPUk.:CD8}V`~u@_06@&ROGTvVS<Gr/v{)Bex?8a' );
define( 'LOGGED_IN_KEY',    'kA:VJolri>HJcggL@2btuCsZ=-sMcLij)PWEYOh|#kmV}22?z^jR1`5?cT/3e/!5' );
define( 'NONCE_KEY',        '0]0]0p/dO|j3mfIav)@/b#FM`xZ1n-CVxPbZr@05Z~CL;pK8yeq~}G@o iN^G5W;' );
define( 'AUTH_SALT',        '-_I_m|(4mxS;@lJ/j<B;,%sn),L<[*#)d{Gyqa)+1yjXCDYauW8t&;=$tc552*C7' );
define( 'SECURE_AUTH_SALT', ';$k^)11i@_[y!GY65,(cL5N?{krE4KX9LdSd/2Evp3|7p2$04L*1p9]jcc|T]m(,' );
define( 'LOGGED_IN_SALT',   ')^}qyul%a.z_#6hy5{.W%*T3-c@hQDAB@qtA9q8D-s/xy.B59h!E>N57awBN@d.S' );
define( 'NONCE_SALT',       '&R~#Oi>2%$([mZKevL%4TtabC[:Wa=L:ZG@Ih(y> jp~>GEr=(|yPv N0W0_v/8^' );

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
