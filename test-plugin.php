<?php
/**
 * Plugin Test File - Ultra Container for Elementor
 * This file helps verify the plugin structure and API compatibility
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Test if the plugin loads correctly
add_action('init', 'ultra_container_test_init');

function ultra_container_test_init() {
    // Check if Elementor is active
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', 'ultra_container_test_elementor_missing');
        return;
    }
    
    // Check if our plugin class exists
    if (!class_exists('Ultra_Container')) {
        add_action('admin_notices', 'ultra_container_test_plugin_class_missing');
        return;
    }
    
    // Check if widget class exists
    if (!class_exists('Elementor\Ultra_Container_Widget')) {
        add_action('admin_notices', 'ultra_container_test_widget_class_missing');
        return;
    }
    
    // All good - show success message
    add_action('admin_notices', 'ultra_container_test_success');
}

function ultra_container_test_elementor_missing() {
    echo '<div class="notice notice-error"><p><strong>Ultra Container Test:</strong> Elementor is not loaded.</p></div>';
}

function ultra_container_test_plugin_class_missing() {
    echo '<div class="notice notice-error"><p><strong>Ultra Container Test:</strong> Main plugin class not found.</p></div>';
}

function ultra_container_test_widget_class_missing() {
    echo '<div class="notice notice-error"><p><strong>Ultra Container Test:</strong> Widget class not found.</p></div>';
}

function ultra_container_test_success() {
    echo '<div class="notice notice-success"><p><strong>Ultra Container Test:</strong> Plugin loaded successfully! All classes found.</p></div>';
}

// Test widget registration
add_action('elementor/widgets/register', 'ultra_container_test_widget_registration');

function ultra_container_test_widget_registration($widgets_manager) {
    // Test if our widget is properly registered
    $widgets = $widgets_manager->get_widget_types();
    
    if (isset($widgets['ultra-container'])) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p><strong>Ultra Container Test:</strong> Widget successfully registered in Elementor!</p></div>';
        });
    } else {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Ultra Container Test:</strong> Widget not found in Elementor registration.</p></div>';
        });
    }
}

// Test category registration
add_action('elementor/elements/categories_registered', 'ultra_container_test_category_registration');

function ultra_container_test_category_registration($elements_manager) {
    $categories = $elements_manager->get_categories();
    
    if (isset($categories['ultra-container'])) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p><strong>Ultra Container Test:</strong> Widget category successfully registered!</p></div>';
        });
    } else {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Ultra Container Test:</strong> Widget category not found.</p></div>';
        });
    }
}

// Test asset registration
add_action('wp_enqueue_scripts', 'ultra_container_test_assets');

function ultra_container_test_assets() {
    // Test if CSS is registered
    global $wp_styles;
    if (isset($wp_styles->registered['ultra-container'])) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p><strong>Ultra Container Test:</strong> CSS assets properly registered!</p></div>';
        });
    }
    
    // Test if JS is registered
    global $wp_scripts;
    if (isset($wp_scripts->registered['ultra-container'])) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p><strong>Ultra Container Test:</strong> JavaScript assets properly registered!</p></div>';
        });
    }
}
