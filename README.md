# Ultra Container for Elementor

A powerful and flexible container widget for Elementor that transforms any content into an interactive button with advanced hover effects, animations, and styling options.

## Features

### 🎯 Core Functionality
- **Flexible Container**: Create containers for any content (images, text, widgets, etc.)
- **Button Mode**: Toggle "Lock as Button" to transform the container into a clickable button
- **Link Integration**: Add custom links with target options (same window/new tab)
- **Responsive Design**: Fully responsive across all devices

### 🎨 Advanced Styling
- **Background Options**: Classic colors, gradients, and images
- **Border Customization**: Full border control with radius options
- **Typography Control**: Complete text styling options
- **Box Shadow**: Multiple shadow effects with hover variations

### ✨ Hover Effects & Animations
- **Background Transitions**: Smooth background color/gradient changes
- **Text Color Changes**: Dynamic text color on hover
- **Border Animations**: Border color and radius transitions
- **Shadow Effects**: Enhanced shadows on hover

### 🚀 Animation Types
1. **Lift Up**: Moves the container upward on hover
2. **Scale**: Grows/shrinks the container
3. **Rotate**: Rotates the container by specified degrees
4. **Slide**: Slides in any direction (left, right, up, down)

### ♿ Accessibility Features
- **Keyboard Navigation**: Full keyboard support for button mode
- **Screen Reader Support**: Proper ARIA attributes
- **Focus Indicators**: Clear focus states for accessibility
- **Reduced Motion**: Respects user's motion preferences

### 📱 Mobile Optimized
- **Touch Events**: Optimized touch interactions
- **Responsive Animations**: Adjusted animation intensity on mobile
- **Performance**: Optimized for mobile devices

## Installation

### Method 1: Upload Plugin File
1. Download the plugin files
2. Upload the `ultra-container` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress

### Method 2: FTP Upload
1. Extract the plugin files
2. Upload the `ultra-container` folder to `/wp-content/plugins/` via FTP
3. Activate the plugin in your WordPress admin

### Method 3: WordPress Admin
1. Go to Plugins → Add New
2. Click "Upload Plugin"
3. Choose the plugin zip file
4. Click "Install Now" and then "Activate"

## Requirements

- **WordPress**: 5.0 or higher
- **Elementor**: 3.0.0 or higher
- **PHP**: 7.4 or higher
- **Memory**: 128MB minimum (256MB recommended)

## Usage

### Basic Setup
1. Edit a page with Elementor
2. Drag the "Ultra Container" widget from the "Ultra Container" category
3. Add your content (text, images, other widgets) to the container
4. Configure styling and effects in the widget settings

### Button Mode
1. Enable "Lock as Button" in the Button Settings tab
2. Add your link URL in the Link field
3. Choose whether to open in a new window
4. The container becomes fully clickable

### Hover Effects
1. Go to the "Hover Effects" tab in the Style panel
2. Enable "Enable Hover Effects"
3. Set transition duration
4. Configure background, text color, and border changes

### Animations
1. In the "Hover Animations" tab, select your animation type:
   - **Lift Up**: Adjust lift distance
   - **Scale**: Set scale amount (1.05 = 5% larger)
   - **Rotate**: Set rotation degrees
   - **Slide**: Choose direction and distance

### Shadow Effects
1. Enable "Enable Hover Shadow" in the Hover Shadow tab
2. Configure shadow properties (color, blur, spread, position)
3. Different shadows can be set for normal and hover states

## Customization Options

### Content Tab
- **Container Content**: Rich text editor for adding content
- **Button Settings**: Link configuration and target options

### Style Tab - Container
- **Padding/Margin**: Spacing controls
- **Border**: Border style, width, color, radius
- **Box Shadow**: Shadow effects

### Style Tab - Background
- **Background Type**: Classic color, gradient, or image
- **Gradient**: Linear and radial gradient options

### Style Tab - Typography
- **Font Settings**: Family, size, weight, style
- **Text Color**: Normal and hover text colors

### Style Tab - Hover Effects
- **Transition Duration**: Animation speed control
- **Background Changes**: Hover background colors/gradients
- **Text Color**: Hover text color
- **Border Changes**: Hover border styling

### Style Tab - Hover Animations
- **Animation Type**: Lift, scale, rotate, or slide
- **Animation Parameters**: Distance, amount, direction settings

### Style Tab - Hover Shadow
- **Shadow Effects**: Enhanced shadows on hover
- **Shadow Properties**: Color, blur, spread, position

### Style Tab - Cursor
- **Cursor Types**: Pointer, help, wait, crosshair, etc.

## Advanced Features

### CSS Custom Properties
The plugin uses CSS custom properties for dynamic styling:
```css
:root {
    --ultra-transition-duration: 0.3s;
    --ultra-lift-distance: -10px;
    --ultra-scale-amount: 1.05;
    --ultra-rotate-amount: 5deg;
    --ultra-slide-distance: 10px;
}
```

### JavaScript API
Access the plugin instance via:
```javascript
window.ultraContainer.refresh(); // Refresh all containers
window.ultraContainer.addContainer(element); // Add new container
```

### Performance Optimizations
- **Will-change Property**: Automatically applied for smooth animations
- **Intersection Observer**: Animations only trigger when visible
- **Debounced Resize**: Optimized window resize handling
- **Reduced Motion**: Respects user accessibility preferences

## Browser Support

- **Chrome**: 60+
- **Firefox**: 55+
- **Safari**: 12+
- **Edge**: 79+
- **Internet Explorer**: Not supported

## Troubleshooting

### Common Issues

**Container not showing hover effects:**
- Ensure "Enable Hover Effects" is turned on
- Check that transition duration is set above 0
- Verify JavaScript is enabled in your browser

**Animations not smooth:**
- Increase transition duration for slower animations
- Check browser performance settings
- Ensure adequate device memory

**Button not clickable:**
- Verify "Lock as Button" is enabled
- Check that a valid URL is provided
- Ensure no overlapping elements are blocking clicks

**Mobile touch issues:**
- Test on actual device (not just browser dev tools)
- Check for CSS conflicts with theme
- Verify touch events are not blocked by other scripts

### Performance Issues

**Slow animations:**
- Reduce transition duration
- Simplify gradient backgrounds
- Use fewer simultaneous animations

**High CPU usage:**
- Disable animations on mobile devices
- Use `prefers-reduced-motion: reduce` media query
- Limit number of animated containers per page

## Development

### File Structure
```
ultra-container/
├── ultra-container.php          # Main plugin file
├── widgets/
│   └── ultra-container-widget.php  # Widget class
├── assets/
│   ├── css/
│   │   └── ultra-container.css     # Styles
│   └── js/
│       └── ultra-container.js      # JavaScript
└── README.md                   # Documentation
```

### Hooks and Filters
```php
// Modify widget categories
add_filter('ultra_container_widget_categories', 'custom_categories');

// Modify default settings
add_filter('ultra_container_default_settings', 'custom_defaults');

// Add custom CSS
add_action('ultra_container_after_enqueue_styles', 'add_custom_css');
```

## Changelog

### Version 1.0.0
- Initial release
- Container widget with button functionality
- Hover effects and animations
- Shadow effects
- Responsive design
- Accessibility features
- Mobile optimization

## Support

For support, feature requests, or bug reports:
- Create an issue in the plugin repository
- Contact the plugin author
- Check the documentation wiki

## License

This plugin is licensed under the GPL v2 or later.

## Credits

Built for Elementor by [Your Name]. Special thanks to the Elementor team for providing an excellent page builder platform.

---

**Note**: This plugin requires Elementor to function. Make sure you have Elementor installed and activated before using Ultra Container.
