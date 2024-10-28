<?php

namespace RRZE\GreenOffice;

/**
 * Plugin Name:     RRZE Green Office
 * Plugin URI:      https://github.com/RRZE-Webteam/rrze-green-office/
 * Description:     Adds an interactive CO2 emission calculator to your website.
 * Version:         1.1.0
 * Requires at least: 6.6
 * Requires PHP:      8.2
 * Author:          RRZE Webteam
 * Author URI:      https://blogs.fau.de/webworking/
 * License:         GNU General Public License v2
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:     /languages
 * Text Domain:     rrze-green-office
 */

// Prevent direct access to this file.
defined('ABSPATH') || exit;

// Plugin requirements.
const REQUIRED_PHP_VERSION = '8.2';
const REQUIRED_WP_VERSION = '6.6';

/**
 * SPL Autoloader (PSR-4).
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__;
    $baseDir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Register activation and deactivation hooks.
register_activation_hook(__FILE__, __NAMESPACE__ . '\activate');
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivate');

// Loaded action hook.
add_action('plugins_loaded', __NAMESPACE__ . '\onLoaded');

/**
 * Load the plugin text domain for translation.
 */
function loadTextdomain()
{
    load_plugin_textdomain('rrze-green-office', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

/**
 * System requirements verification.
 * @return string Return an error message or an empty string.
 */
function systemRequirements(): string
{
    global $wp_version;
    // Strip off any -alpha, -RC, -beta, -src suffixes.
    list($wpVersion) = explode('-', $wp_version);
    $phpVersion = phpversion();
    $error = '';
    if (!is_php_version_compatible(REQUIRED_PHP_VERSION)) {
        $error = sprintf(
            /* translators: 1: Server PHP version number, 2: Required PHP version number. */
            __('The server is running PHP version %1$s. The Plugin requires at least PHP version %2$s.', 'rrze-green-office'),
            $phpVersion,
            REQUIRED_PHP_VERSION
        );
    } elseif (!is_wp_version_compatible(REQUIRED_WP_VERSION)) {
        $error = sprintf(
            /* translators: 1: Server WordPress version number, 2: Required WordPress version number. */
            __('The server is running WordPress version %1$s. The Plugin requires at least WordPress version %2$s.', 'rrze-green-office'),
            $wpVersion,
            REQUIRED_WP_VERSION
        );
    }
    return $error;
}

/**
 * Activation hook.
 */
function activate()
{
    loadTextdomain();
    if ($error = systemRequirements()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            sprintf(
                /* translators: 1: The plugin name, 2: The error string. */
                esc_html__('Plugins: %1$s: %2$s', 'rrze-green-office'),
                esc_html(plugin_basename(__FILE__)),
                esc_html($error)
            )
        );
    }
}

/**
 * Deactivation hook.
 */
function deactivate()
{
    // Any deactivation tasks can be added here.
}

/**
 * Execute on 'plugins_loaded' API/action.
 */
function onLoaded()
{
    loadTextdomain();
    if ($error = systemRequirements()) {
        add_action('admin_init', function () use ($error) {
            if (current_user_can('activate_plugins')) {
                $pluginName = plugin_basename(__FILE__);
                $tag = is_plugin_active_for_network(plugin_basename(__FILE__)) ? 'network_admin_notices' : 'admin_notices';
                add_action($tag, function () use ($pluginName, $error) {
                    printf(
                        '<div class="notice notice-error"><p>' .
                            /* translators: 1: The plugin name, 2: The error string. */
                            esc_html__('Plugins: %1$s: %2$s', 'rrze-green-office') .
                            '</p></div>',
                        esc_html($pluginName),
                        esc_html($error)
                    );
                });
            }
        });
        return;
    }

    // Initialize Main class && call onLoaded method.
    (new Main(__FILE__))->onLoaded();

    add_action('init', __NAMESPACE__ . '\createBlockRrzeGreenOffice');
}

function createBlockRrzeGreenOffice() {
    register_block_type( __DIR__ . '/build' );
}
