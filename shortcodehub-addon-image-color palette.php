<?php
/**
 * Plugin Name: ShortcodeHub Addon - Image Color Palette
 * Plugin URI: https://surror.com/
 * Description: Grabs the dominant color or a representative color palette from an image. Uses javascript and canvas.
 * Version: 1.0.0
 * Author: ShortcodeHub
 * Author URI: https://shortcodehub.com/
 * Text Domain: shortcodehub
 *
 * @package ShortcodeHub
 *   _____ __               __                 __     __  __      __
 *  / ___// /_  ____  _____/ /__________  ____/ /__  / / / /_  __/ /_
 *  \__ \/ __ \/ __ \/ ___/ __/ ___/ __ \/ __  / _ \/ /_/ / / / / __ \
 * ___/ / / / / /_/ / /  / /_/ /__/ /_/ / /_/ /  __/ __  / /_/ / /_/ /
 * ____/_/ /_/\____/_/   \__/\___/\____/\__,_/\___/_/ /_/\__,_/_.___/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set Constants.
define( 'SH_ADDON_ICP_VER', '1.0.0' );
define( 'SH_ADDON_ICP_FILE', __FILE__ );
define( 'SH_ADDON_ICP_BASE', plugin_basename( SH_ADDON_ICP_FILE ) );
define( 'SH_ADDON_ICP_DIR', plugin_dir_path( SH_ADDON_ICP_FILE ) );
define( 'SH_ADDON_ICP_URI', plugins_url( '/', SH_ADDON_ICP_FILE ) );

require_once SH_ADDON_ICP_DIR . 'classes/class-sh-addon-icp-loader.php';