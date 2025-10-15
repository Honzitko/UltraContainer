<?php
/**
 * Plugin Name: Ultra Container for Elementor
 * Plugin URI: https://your-website.com
 * Description: A powerful container widget for Elementor with advanced button functionality, hover effects, and animations.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://your-website.com
 * Text Domain: ultra-container
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Elementor tested up to: 3.18
 * Elementor Pro tested up to: 3.18
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ULTRA_CONTAINER_VERSION', '1.0.0');
define('ULTRA_CONTAINER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ULTRA_CONTAINER_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main Ultra Container Class
 */
final class Ultra_Container {

    /**
     * Plugin Version
     */
    const VERSION = ULTRA_CONTAINER_VERSION;

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
        
        // Include test file in development
        if (defined('WP_DEBUG') && WP_DEBUG) {
            require_once ULTRA_CONTAINER_PLUGIN_PATH . 'test-plugin.php';
        }
    }

    /**
     * Load Textdomain
     */
    public function i18n() {
        load_plugin_textdomain('ultra-container');
    }

    /**
     * On Plugins Loaded
     */
    public function on_plugins_loaded() {
        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }
    }

    /**
     * Compatibility Checks
     */
    public function is_compatible() {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

        return true;
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        $this->i18n();

        // Add Plugin actions - Updated for latest Elementor API
        add_action('elementor/widgets/register', [$this, 'init_widgets']);
        add_action('elementor/controls/register', [$this, 'init_controls']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Register Widget Category - Updated for latest Elementor API
        add_action('elementor/elements/categories_registered', [$this, 'add_widget_categories']);
    }

    /**
     * Init Widgets
     */
    public function init_widgets($widgets_manager) {
        // Include Widget files
        require_once ULTRA_CONTAINER_PLUGIN_PATH . 'widgets/ultra-container-widget.php';

        // Register widget - Updated for latest Elementor API
        $widgets_manager->register(new \Elementor\Ultra_Container_Widget());
    }

    /**
     * Init Controls
     */
    public function init_controls($controls_manager) {
        // Include Control files if needed
        // require_once ULTRA_CONTAINER_PLUGIN_PATH . 'controls/ultra-container-control.php';

        // Register control - Updated for latest Elementor API
        // $controls_manager->register(new \Ultra_Container_Control());
    }

    /**
     * Widget Styles
     */
    public function widget_styles() {
        wp_register_style(
            'ultra-container', 
            ULTRA_CONTAINER_PLUGIN_URL . 'assets/css/ultra-container.css', 
            [], 
            self::VERSION
        );
    }

    /**
     * Widget Scripts
     */
    public function widget_scripts() {
        wp_register_script(
            'ultra-container', 
            ULTRA_CONTAINER_PLUGIN_URL . 'assets/js/ultra-container.js', 
            ['jquery'], 
            self::VERSION, 
            true
        );
    }

    /**
     * Add Widget Categories
     */
    public function add_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'ultra-container',
            [
                'title' => __('Ultra Container', 'ultra-container'),
                'icon' => 'fa fa-cube',
            ]
        );
    }

    /**
     * Admin notice
     */
    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'ultra-container'),
            '<strong>' . esc_html__('Ultra Container for Elementor', 'ultra-container') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'ultra-container') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'ultra-container'),
            '<strong>' . esc_html__('Ultra Container for Elementor', 'ultra-container') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'ultra-container') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'ultra-container'),
            '<strong>' . esc_html__('Ultra Container for Elementor', 'ultra-container') . '</strong>',
            '<strong>' . esc_html__('PHP', 'ultra-container') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}

Ultra_Container::instance();

/**
 * Plugin activation hook
 */
register_activation_hook(__FILE__, 'ultra_container_activate');

function ultra_container_activate() {
    // Ensure the helper function is available when activating outside the admin
    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    // Check if Elementor is active
    if (!is_plugin_active('elementor/elementor.php')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            __('Ultra Container for Elementor requires Elementor to be installed and activated.', 'ultra-container'),
            __('Plugin Activation Error', 'ultra-container'),
            ['back_link' => true]
        );
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Plugin deactivation hook
 */
register_deactivation_hook(__FILE__, 'ultra_container_deactivate');

function ultra_container_deactivate() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
