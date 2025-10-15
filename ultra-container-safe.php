<?php
/**
 * Plugin Name: Ultra Container for Elementor (Safe Version)
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
 * Main Ultra Container Class - Safe Version
 */
final class Ultra_Container_Safe {

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
        // Use a safer approach to plugin loading
        add_action('init', [$this, 'init'], 20);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Check compatibility first
        if (!$this->is_compatible()) {
            return;
        }

        // Load textdomain
        load_plugin_textdomain('ultra-container', false, dirname(plugin_basename(__FILE__)) . '/languages');

        // Register assets
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'enqueue_scripts']);

        // Register widget and category
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_widget_categories']);
    }

    /**
     * Compatibility Checks
     */
    public function is_compatible() {
        // Check if Elementor is available
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }

        // Check for required Elementor version
        if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<')) {
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            return false;
        }

        return true;
    }

    /**
     * Register assets
     */
    public function register_assets() {
        wp_register_style(
            'ultra-container-safe',
            ULTRA_CONTAINER_PLUGIN_URL . 'assets/css/ultra-container.css',
            [],
            self::VERSION
        );

        wp_register_script(
            'ultra-container-safe',
            ULTRA_CONTAINER_PLUGIN_URL . 'assets/js/ultra-container.js',
            ['jquery'],
            self::VERSION,
            true
        );
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles() {
        wp_enqueue_style('ultra-container-safe');
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script('ultra-container-safe');
    }

    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        // Include widget file safely
        $widget_file = ULTRA_CONTAINER_PLUGIN_PATH . 'widgets/ultra-container-widget.php';
        
        if (file_exists($widget_file)) {
            try {
                require_once $widget_file;
                
                // Register widget if class exists
                if (class_exists('Elementor\Ultra_Container_Widget')) {
                    $widgets_manager->register(new \Elementor\Ultra_Container_Widget());
                }
            } catch (Exception $e) {
                // Log error silently
                error_log('Ultra Container Widget Error: ' . $e->getMessage());
            }
        }
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
}

// Initialize the plugin safely
Ultra_Container_Safe::instance();

/**
 * Safe plugin activation hook
 */
register_activation_hook(__FILE__, 'ultra_container_safe_activate');

function ultra_container_safe_activate() {
    // Simple activation without complex checks
    flush_rewrite_rules();
}

/**
 * Safe plugin deactivation hook
 */
register_deactivation_hook(__FILE__, 'ultra_container_safe_deactivate');

function ultra_container_safe_deactivate() {
    flush_rewrite_rules();
}
