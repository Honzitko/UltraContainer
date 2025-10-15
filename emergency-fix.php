<?php
/**
 * Emergency Fix Script for Ultra Container Plugin
 * Run this to quickly identify and fix the critical error
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Ultra Container Emergency Fix</h1>\n";
echo "<hr>\n";

// Step 1: Check if we can access WordPress
echo "<h2>1. WordPress Access Check</h2>\n";

// Try to find wp-config.php
$wp_config_paths = [
    __DIR__ . '/../../../../wp-config.php',
    __DIR__ . '/../../../../../wp-config.php',
    __DIR__ . '/../../../../../../wp-config.php'
];

$wp_loaded = false;
foreach ($wp_config_paths as $path) {
    if (file_exists($path)) {
        echo "✅ Found wp-config.php at: {$path}\n";
        try {
            require_once $path;
            $wp_loaded = true;
            break;
        } catch (Exception $e) {
            echo "❌ Error loading wp-config.php: " . $e->getMessage() . "\n";
        }
    }
}

if (!$wp_loaded) {
    echo "❌ Could not load WordPress. Manual intervention required.\n";
    echo "<h3>Manual Steps:</h3>\n";
    echo "<ol>\n";
    echo "<li>Access your hosting control panel or FTP</li>\n";
    echo "<li>Navigate to /wp-content/plugins/</li>\n";
    echo "<li>Rename 'ultra-container' folder to 'ultra-container-disabled'</li>\n";
    echo "<li>This will deactivate the plugin and restore your site</li>\n";
    echo "</ol>\n";
    exit;
}

echo "✅ WordPress loaded successfully\n";
echo "WordPress Version: " . get_bloginfo('version') . "\n";
echo "PHP Version: " . PHP_VERSION . "\n";

// Step 2: Check plugin status
echo "<h2>2. Plugin Status Check</h2>\n";

$plugin_file = 'ultra-container/ultra-container.php';
if (is_plugin_active($plugin_file)) {
    echo "❌ Plugin is still active - this might be causing the error\n";
    echo "<strong>IMMEDIATE ACTION REQUIRED:</strong>\n";
    echo "<ol>\n";
    echo "<li>Go to WordPress Admin → Plugins</li>\n";
    echo "<li>Find 'Ultra Container for Elementor'</li>\n";
    echo "<li>Click 'Deactivate'</li>\n";
    echo "</ol>\n";
} else {
    echo "✅ Plugin is deactivated\n";
}

// Step 3: Check for syntax errors
echo "<h2>3. Syntax Error Check</h2>\n";

$files_to_check = [
    'ultra-container.php',
    'widgets/ultra-container-widget.php'
];

foreach ($files_to_check as $file) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);
        
        // Basic syntax checks
        if (strpos($content, '<?php') === false) {
            echo "❌ {$file}: Missing PHP opening tag\n";
        } else {
            echo "✅ {$file}: PHP opening tag found\n";
        }
        
        // Check for common syntax errors
        $errors = [];
        
        // Check for unmatched braces
        $open_braces = substr_count($content, '{');
        $close_braces = substr_count($content, '}');
        if ($open_braces !== $close_braces) {
            $errors[] = "Unmatched braces ({$open_braces} open, {$close_braces} close)";
        }
        
        // Check for unmatched parentheses
        $open_parens = substr_count($content, '(');
        $close_parens = substr_count($content, ')');
        if ($open_parens !== $close_parens) {
            $errors[] = "Unmatched parentheses ({$open_parens} open, {$close_parens} close)";
        }
        
        // Check for unmatched quotes
        $single_quotes = substr_count($content, "'");
        $double_quotes = substr_count($content, '"');
        if ($single_quotes % 2 !== 0 || $double_quotes % 2 !== 0) {
            $errors[] = "Possible unmatched quotes";
        }
        
        if (empty($errors)) {
            echo "✅ {$file}: Basic syntax checks passed\n";
        } else {
            echo "❌ {$file}: Potential syntax issues:\n";
            foreach ($errors as $error) {
                echo "   - {$error}\n";
            }
        }
    } else {
        echo "❌ {$file}: File not found\n";
    }
}

// Step 4: Check error log
echo "<h2>4. Error Log Check</h2>\n";

$error_log_paths = [
    __DIR__ . '/../../../../wp-content/debug.log',
    __DIR__ . '/../../../../../wp-content/debug.log',
    '/var/log/apache2/error.log',
    '/var/log/nginx/error.log'
];

$error_found = false;
foreach ($error_log_paths as $log_path) {
    if (file_exists($log_path)) {
        echo "Found error log: {$log_path}\n";
        $recent_errors = shell_exec("tail -10 " . escapeshellarg($log_path) . " 2>/dev/null");
        if ($recent_errors) {
            echo "<h3>Recent Errors:</h3>\n";
            echo "<pre>{$recent_errors}</pre>\n";
            $error_found = true;
        }
        break;
    }
}

if (!$error_found) {
    echo "⚠️ No error log found or accessible\n";
}

// Step 5: Provide solutions
echo "<h2>5. Recommended Solutions</h2>\n";

echo "<h3>Immediate Fix:</h3>\n";
echo "<ol>\n";
echo "<li><strong>Deactivate the plugin immediately:</strong>\n";
echo "   - Go to WordPress Admin → Plugins\n";
echo "   - Find 'Ultra Container for Elementor'\n";
echo "   - Click 'Deactivate'\n";
echo "</li>\n";
echo "<li><strong>If you can't access admin:</strong>\n";
echo "   - Use FTP or hosting control panel\n";
echo "   - Navigate to /wp-content/plugins/\n";
echo "   - Rename 'ultra-container' to 'ultra-container-disabled'\n";
echo "</li>\n";
echo "</ol>\n";

echo "<h3>After Deactivating:</h3>\n";
echo "<ol>\n";
echo "<li><strong>Use the safe version:</strong>\n";
echo "   - Replace ultra-container.php with ultra-container-safe.php\n";
echo "   - Replace ultra-container-widget.php with ultra-container-widget-safe.php\n";
echo "</li>\n";
echo "<li><strong>Enable debug mode:</strong>\n";
echo "   - Add to wp-config.php: define('WP_DEBUG', true);\n";
echo "   - Add to wp-config.php: define('WP_DEBUG_LOG', true);\n";
echo "</li>\n";
echo "<li><strong>Increase memory limit:</strong>\n";
echo "   - Add to wp-config.php: ini_set('memory_limit', '256M');\n";
echo "</li>\n";
echo "</ol>\n";

echo "<h3>Test the Fix:</h3>\n";
echo "<ol>\n";
echo "<li>Activate the safe version of the plugin\n";
echo "<li>Edit a page with Elementor\n";
echo "<li>Look for 'Ultra Container' widget\n";
echo "<li>Test basic functionality\n";
echo "</ol>\n";

echo "<hr>\n";
echo "<p><strong>If problems persist:</strong> Check the CRITICAL-ERROR-RECOVERY.md file for detailed troubleshooting steps.</p>\n";
echo "<p><em>Emergency fix completed at: " . date('Y-m-d H:i:s') . "</em></p>\n";
?>
