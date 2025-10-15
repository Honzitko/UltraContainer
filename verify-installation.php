<?php
/**
 * Ultra Container Installation Verification Script
 * Run this file to verify the plugin installation and Elementor integration
 */

// Define WordPress root directory (adjust if needed)
$wp_root = dirname(__FILE__) . '/../../../../';
if (!file_exists($wp_root . 'wp-config.php')) {
    $wp_root = dirname(__FILE__) . '/../../../../../';
}

// Load WordPress
require_once $wp_root . 'wp-config.php';

echo "<h1>Ultra Container for Elementor - Installation Verification</h1>\n";
echo "<hr>\n";

// Check 1: Plugin file exists
echo "<h2>1. Plugin File Check</h2>\n";
$plugin_file = dirname(__FILE__) . '/ultra-container.php';
if (file_exists($plugin_file)) {
    echo "✅ Plugin file exists: ultra-container.php\n";
} else {
    echo "❌ Plugin file missing: ultra-container.php\n";
}

// Check 2: Widget file exists
echo "<h2>2. Widget File Check</h2>\n";
$widget_file = dirname(__FILE__) . '/widgets/ultra-container-widget.php';
if (file_exists($widget_file)) {
    echo "✅ Widget file exists: widgets/ultra-container-widget.php\n";
} else {
    echo "❌ Widget file missing: widgets/ultra-container-widget.php\n";
}

// Check 3: Asset files exist
echo "<h2>3. Asset Files Check</h2>\n";
$css_file = dirname(__FILE__) . '/assets/css/ultra-container.css';
$js_file = dirname(__FILE__) . '/assets/js/ultra-container.js';

if (file_exists($css_file)) {
    echo "✅ CSS file exists: assets/css/ultra-container.css\n";
} else {
    echo "❌ CSS file missing: assets/css/ultra-container.css\n";
}

if (file_exists($js_file)) {
    echo "✅ JavaScript file exists: assets/js/ultra-container.js\n";
} else {
    echo "❌ JavaScript file missing: assets/js/ultra-container.js\n";
}

// Check 4: WordPress and Elementor
echo "<h2>4. WordPress & Elementor Check</h2>\n";

// Check WordPress version
global $wp_version;
echo "WordPress Version: " . $wp_version . "\n";

// Check if Elementor is active
if (did_action('elementor/loaded')) {
    echo "✅ Elementor is loaded\n";
    
    // Check Elementor version
    if (defined('ELEMENTOR_VERSION')) {
        echo "Elementor Version: " . ELEMENTOR_VERSION . "\n";
    }
} else {
    echo "❌ Elementor is not loaded or not active\n";
}

// Check 5: Plugin classes
echo "<h2>5. Plugin Classes Check</h2>\n";

if (class_exists('Ultra_Container')) {
    echo "✅ Main plugin class exists: Ultra_Container\n";
} else {
    echo "❌ Main plugin class missing: Ultra_Container\n";
}

if (class_exists('Elementor\Ultra_Container_Widget')) {
    echo "✅ Widget class exists: Elementor\Ultra_Container_Widget\n";
} else {
    echo "❌ Widget class missing: Elementor\Ultra_Container_Widget\n";
}

// Check 6: Widget registration
echo "<h2>6. Widget Registration Check</h2>\n";

if (class_exists('Elementor\Plugin')) {
    $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
    $widgets = $widgets_manager->get_widget_types();
    
    if (isset($widgets['ultra-container'])) {
        echo "✅ Widget registered in Elementor: ultra-container\n";
    } else {
        echo "❌ Widget not registered in Elementor: ultra-container\n";
    }
} else {
    echo "❌ Elementor Plugin class not available\n";
}

// Check 7: Category registration
echo "<h2>7. Widget Category Check</h2>\n";

if (class_exists('Elementor\Plugin')) {
    $elements_manager = \Elementor\Plugin::instance()->elements_manager;
    $categories = $elements_manager->get_categories();
    
    if (isset($categories['ultra-container'])) {
        echo "✅ Widget category registered: ultra-container\n";
    } else {
        echo "❌ Widget category not registered: ultra-container\n";
    }
} else {
    echo "❌ Elementor Elements Manager not available\n";
}

// Check 8: Asset registration
echo "<h2>8. Asset Registration Check</h2>\n";

global $wp_styles, $wp_scripts;

if (isset($wp_styles->registered['ultra-container'])) {
    echo "✅ CSS asset registered: ultra-container\n";
} else {
    echo "❌ CSS asset not registered: ultra-container\n";
}

if (isset($wp_scripts->registered['ultra-container'])) {
    echo "✅ JavaScript asset registered: ultra-container\n";
} else {
    echo "❌ JavaScript asset not registered: ultra-container\n";
}

echo "<hr>\n";
echo "<h2>Installation Summary</h2>\n";

// Count successful checks
$checks = [
    file_exists($plugin_file),
    file_exists($widget_file),
    file_exists($css_file),
    file_exists($js_file),
    did_action('elementor/loaded'),
    class_exists('Ultra_Container'),
    class_exists('Elementor\Ultra_Container_Widget')
];

$successful_checks = array_sum($checks);
$total_checks = count($checks);

echo "Successful checks: {$successful_checks}/{$total_checks}\n";

if ($successful_checks === $total_checks) {
    echo "<h3 style='color: green;'>🎉 All checks passed! Plugin should work correctly.</h3>\n";
} else {
    echo "<h3 style='color: red;'>⚠️ Some checks failed. Please review the issues above.</h3>\n";
}

echo "<p><strong>Next steps:</strong></p>\n";
echo "<ul>\n";
echo "<li>1. Edit a page with Elementor</li>\n";
echo "<li>2. Look for 'Ultra Container' in the widget panel under 'Ultra Container' category</li>\n";
echo "<li>3. Drag the widget to your page and test the functionality</li>\n";
echo "</ul>\n";

echo "<hr>\n";
echo "<p><em>Verification completed at: " . date('Y-m-d H:i:s') . "</em></p>\n";
?>
