<?php
/**
 * Ultra Container Debug Script
 * Run this to identify and fix critical errors
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Ultra Container Debug Script</h1>\n";
echo "<hr>\n";

// Check 1: Basic PHP syntax
echo "<h2>1. PHP Syntax Check</h2>\n";

$files_to_check = [
    'ultra-container.php',
    'widgets/ultra-container-widget.php'
];

foreach ($files_to_check as $file) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        $output = shell_exec("php -l " . escapeshellarg($file_path) . " 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "✅ {$file}: No syntax errors\n";
        } else {
            echo "❌ {$file}: Syntax error detected\n";
            echo "<pre>{$output}</pre>\n";
        }
    } else {
        echo "❌ {$file}: File not found\n";
    }
}

// Check 2: WordPress environment
echo "<h2>2. WordPress Environment Check</h2>\n";

if (defined('ABSPATH')) {
    echo "✅ WordPress is loaded\n";
    echo "WordPress Version: " . get_bloginfo('version') . "\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
} else {
    echo "❌ WordPress not loaded - trying to load manually\n";
    
    // Try to find wp-config.php
    $wp_config_paths = [
        __DIR__ . '/../../../../wp-config.php',
        __DIR__ . '/../../../../../wp-config.php',
        __DIR__ . '/../../../../../../wp-config.php'
    ];
    
    foreach ($wp_config_paths as $path) {
        if (file_exists($path)) {
            echo "Found wp-config.php at: {$path}\n";
            require_once $path;
            break;
        }
    }
}

// Check 3: Elementor status
echo "<h2>3. Elementor Status Check</h2>\n";

if (function_exists('is_plugin_active')) {
    if (is_plugin_active('elementor/elementor.php')) {
        echo "✅ Elementor is active\n";
        if (defined('ELEMENTOR_VERSION')) {
            echo "Elementor Version: " . ELEMENTOR_VERSION . "\n";
        }
    } else {
        echo "❌ Elementor is not active\n";
    }
} else {
    echo "⚠️ Cannot check plugin status (WordPress not fully loaded)\n";
}

// Check 4: Plugin files integrity
echo "<h2>4. Plugin Files Integrity Check</h2>\n";

$required_files = [
    'ultra-container.php',
    'widgets/ultra-container-widget.php',
    'assets/css/ultra-container.css',
    'assets/js/ultra-container.js'
];

foreach ($required_files as $file) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        $size = filesize($file_path);
        echo "✅ {$file}: Exists ({$size} bytes)\n";
        
        // Check if file is readable
        if (is_readable($file_path)) {
            echo "  - File is readable\n";
        } else {
            echo "  - ❌ File is not readable\n";
        }
    } else {
        echo "❌ {$file}: Missing\n";
    }
}

// Check 5: Memory and limits
echo "<h2>5. Server Limits Check</h2>\n";

echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "\n";
echo "Post Max Size: " . ini_get('post_max_size') . "\n";

// Check 6: Error log
echo "<h2>6. Error Log Check</h2>\n";

$error_log_paths = [
    __DIR__ . '/../../../../wp-content/debug.log',
    __DIR__ . '/../../../../../wp-content/debug.log',
    '/var/log/apache2/error.log',
    '/var/log/nginx/error.log'
];

foreach ($error_log_paths as $log_path) {
    if (file_exists($log_path)) {
        echo "Found error log: {$log_path}\n";
        $recent_errors = shell_exec("tail -20 " . escapeshellarg($log_path) . " 2>/dev/null");
        if ($recent_errors) {
            echo "<h3>Recent Errors:</h3>\n";
            echo "<pre>{$recent_errors}</pre>\n";
        }
        break;
    }
}

// Check 7: Plugin activation status
echo "<h2>7. Plugin Status Check</h2>\n";

if (function_exists('is_plugin_active')) {
    $plugin_file = 'ultra-container/ultra-container.php';
    if (is_plugin_active($plugin_file)) {
        echo "✅ Ultra Container plugin is active\n";
    } else {
        echo "❌ Ultra Container plugin is not active\n";
    }
}

echo "<hr>\n";
echo "<h2>Quick Fixes to Try:</h2>\n";
echo "<ol>\n";
echo "<li><strong>Deactivate Plugin:</strong> Go to WordPress Admin > Plugins and deactivate Ultra Container</li>\n";
echo "<li><strong>Check Error Logs:</strong> Look in wp-content/debug.log for specific error messages</li>\n";
echo "<li><strong>Increase Memory:</strong> Add <code>ini_set('memory_limit', '256M');</code> to wp-config.php</li>\n";
echo "<li><strong>Enable Debug Mode:</strong> Add <code>define('WP_DEBUG', true);</code> to wp-config.php</li>\n";
echo "<li><strong>Check File Permissions:</strong> Ensure plugin files are readable (644 for files, 755 for directories)</li>\n";
echo "</ol>\n";

echo "<hr>\n";
echo "<p><em>Debug completed at: " . date('Y-m-d H:i:s') . "</em></p>\n";
?>
