# Critical Error Recovery Guide

## 🚨 IMMEDIATE ACTIONS TO TAKE

### Step 1: Deactivate the Plugin (URGENT)
1. **Via FTP/File Manager:**
   - Navigate to `/wp-content/plugins/`
   - Rename the `ultra-container` folder to `ultra-container-disabled`
   - This will deactivate the plugin immediately

2. **Via WordPress Admin (if accessible):**
   - Go to Plugins → Installed Plugins
   - Find "Ultra Container for Elementor"
   - Click "Deactivate"

### Step 2: Check Error Logs
1. **Find the error log:**
   - Look in `/wp-content/debug.log`
   - Check your hosting control panel error logs
   - Look for PHP fatal errors

2. **Common error patterns to look for:**
   ```
   Fatal error: Class 'Elementor\Ultra_Container_Widget' not found
   Fatal error: Cannot redeclare class
   Fatal error: Call to undefined method
   ```

## 🔧 DIAGNOSIS STEPS

### Run the Debug Script
1. Upload `debug-plugin.php` to your plugin folder
2. Access it via browser: `yoursite.com/wp-content/plugins/ultra-container/debug-plugin.php`
3. Check the output for specific error messages

### Check File Permissions
```bash
# Set correct permissions
chmod 644 ultra-container.php
chmod 644 widgets/ultra-container-widget.php
chmod 644 assets/css/ultra-container.css
chmod 644 assets/js/ultra-container.js
chmod 755 widgets/
chmod 755 assets/
chmod 755 assets/css/
chmod 755 assets/js/
```

### Verify File Integrity
Check that these files exist and are not empty:
- ✅ `ultra-container.php` (main plugin file)
- ✅ `widgets/ultra-container-widget.php` (widget class)
- ✅ `assets/css/ultra-container.css` (styles)
- ✅ `assets/js/ultra-container.js` (scripts)

## 🛠️ FIXING THE ISSUE

### Option 1: Use the Safe Version
1. **Replace the main plugin file:**
   - Backup your current `ultra-container.php`
   - Replace it with `ultra-container-safe.php`
   - Rename `ultra-container-safe.php` to `ultra-container.php`

2. **Replace the widget file:**
   - Backup your current `widgets/ultra-container-widget.php`
   - Replace it with `widgets/ultra-container-widget-safe.php`
   - Rename `ultra-container-widget-safe.php` to `ultra-container-widget.php`

### Option 2: Fix the Original Plugin
Common fixes for the original plugin:

#### Fix 1: Class Name Conflicts
```php
// In ultra-container-widget.php, ensure the class name is:
class Ultra_Container_Widget extends Widget_Base {
    // NOT: class Ultra_Container_Widget extends \Elementor\Widget_Base {
}
```

#### Fix 2: Namespace Issues
```php
// At the top of ultra-container-widget.php:
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
```

#### Fix 3: Missing Dependencies
Add this to your `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
ini_set('memory_limit', '256M');
```

### Option 3: Minimal Working Version
If both versions fail, create a minimal version:

1. **Create `ultra-container-minimal.php`:**
```php
<?php
/**
 * Plugin Name: Ultra Container Minimal
 * Description: Minimal container widget for Elementor
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

add_action('elementor/widgets/register', function($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'widgets/ultra-container-minimal.php';
    $widgets_manager->register(new \Elementor\Ultra_Container_Minimal());
});
```

2. **Create `widgets/ultra-container-minimal.php`:**
```php
<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Ultra_Container_Minimal extends Widget_Base {
    public function get_name() { return 'ultra-container-minimal'; }
    public function get_title() { return __('Ultra Container', 'ultra-container'); }
    public function get_icon() { return 'eicon-container'; }
    public function get_categories() { return ['general']; }
    
    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'ultra-container'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        
        $this->add_control('content', [
            'label' => __('Content', 'ultra-container'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Hello World!', 'ultra-container'),
        ]);
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<div class="ultra-container-minimal">' . esc_html($settings['content']) . '</div>';
    }
}
```

## 🧪 TESTING THE FIX

### Step 1: Test Plugin Activation
1. Try to activate the plugin
2. Check for any error messages
3. If successful, proceed to step 2

### Step 2: Test Elementor Integration
1. Edit a page with Elementor
2. Look for your widget in the widget panel
3. Try dragging it to the page

### Step 3: Test Frontend
1. View the page on the frontend
2. Check that the widget displays correctly
3. Test any interactive features

## 📞 GETTING HELP

### If You're Still Stuck:

1. **Check Error Logs Again:**
   - Look for the specific PHP fatal error
   - Note the file and line number where it occurs

2. **Common Error Solutions:**
   - **"Class not found"**: File not being included properly
   - **"Cannot redeclare"**: Plugin loaded twice
   - **"Fatal error"**: PHP syntax error in code

3. **Hosting-Specific Issues:**
   - Some hosts have restrictions on certain PHP functions
   - Check if your hosting supports the required PHP version
   - Verify file permissions are correct

4. **Plugin Conflicts:**
   - Deactivate all other plugins temporarily
   - Test if the plugin works with just Elementor
   - Reactivate plugins one by one to find conflicts

## 🚀 PREVENTION FOR FUTURE

### Best Practices:
1. **Always test on staging first**
2. **Keep backups of working versions**
3. **Enable debug mode during development**
4. **Check error logs regularly**
5. **Use version control for your plugins**

### Safe Development:
1. Start with minimal functionality
2. Add features incrementally
3. Test after each addition
4. Use proper error handling
5. Follow WordPress coding standards

---

**Remember:** The safe version is designed to be more stable and less likely to cause critical errors. If you're experiencing issues, start with that version and gradually add features back.
