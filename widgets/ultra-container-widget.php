<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Ultra Container Widget
 */
class Ultra_Container_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'ultra-container';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __('Ultra Container', 'ultra-container');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-container';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return ['ultra-container'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['container', 'button', 'hover', 'animation', 'ultra'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['ultra-container'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['ultra-container'];
    }

    /**
     * Enqueue widget scripts and styles.
     */
    public function enqueue_scripts() {
        wp_enqueue_style('ultra-container');
        wp_enqueue_script('ultra-container');
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ultra-container'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'container_content',
            [
                'label' => __('Container Content', 'ultra-container'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Add your content here...', 'ultra-container'),
                'placeholder' => __('Type your content here', 'ultra-container'),
            ]
        );

        $this->end_controls_section();

        // Button Settings Tab
        $this->start_controls_section(
            'button_section',
            [
                'label' => __('Button Settings', 'ultra-container'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_button',
            [
                'label' => __('Lock as Button', 'ultra-container'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ultra-container'),
                'label_off' => __('No', 'ultra-container'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Link', 'ultra-container'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'ultra-container'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'enable_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_target',
            [
                'label' => __('Open in new window', 'ultra-container'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ultra-container'),
                'label_off' => __('No', 'ultra-container'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'enable_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Container
        $this->start_controls_section(
            'container_style_section',
            [
                'label' => __('Container', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => __('Padding', 'ultra-container'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_margin',
            [
                'label' => __('Margin', 'ultra-container'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => __('Border', 'ultra-container'),
                'selector' => '{{WRAPPER}} .ultra-container',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => __('Border Radius', 'ultra-container'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => __('Box Shadow', 'ultra-container'),
                'selector' => '{{WRAPPER}} .ultra-container',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Background
        $this->start_controls_section(
            'background_style_section',
            [
                'label' => __('Background', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => __('Background', 'ultra-container'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ultra-container',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Typography
        $this->start_controls_section(
            'typography_style_section',
            [
                'label' => __('Typography', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'container_typography',
                'label' => __('Typography', 'ultra-container'),
                'selector' => '{{WRAPPER}} .ultra-container',
            ]
        );

        $this->add_control(
            'container_text_color',
            [
                'label' => __('Text Color', 'ultra-container'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Hover Effects
        $this->start_controls_section(
            'hover_effects_section',
            [
                'label' => __('Hover Effects', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enable_hover_effects',
            [
                'label' => __('Enable Hover Effects', 'ultra-container'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ultra-container'),
                'label_off' => __('No', 'ultra-container'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'hover_duration',
            [
                'label' => __('Transition Duration', 'ultra-container'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hover_background_heading',
            [
                'label' => __('Hover Background', 'ultra-container'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_background',
                'label' => __('Hover Background', 'ultra-container'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ultra-container:hover',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => __('Hover Text Color', 'ultra-container'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ultra-container:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hover_border_heading',
            [
                'label' => __('Hover Border', 'ultra-container'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'hover_border',
                'label' => __('Hover Border', 'ultra-container'),
                'selector' => '{{WRAPPER}} .ultra-container:hover',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'hover_border_radius',
            [
                'label' => __('Hover Border Radius', 'ultra-container'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Hover Animations
        $this->start_controls_section(
            'hover_animations_section',
            [
                'label' => __('Hover Animations', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_animation_type',
            [
                'label' => __('Animation Type', 'ultra-container'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'ultra-container'),
                    'lift' => __('Lift Up', 'ultra-container'),
                    'scale' => __('Scale', 'ultra-container'),
                    'rotate' => __('Rotate', 'ultra-container'),
                    'slide' => __('Slide', 'ultra-container'),
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lift_distance',
            [
                'label' => __('Lift Distance', 'ultra-container'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container.ultra-lift:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'hover_animation_type' => 'lift',
                ],
            ]
        );

        $this->add_control(
            'scale_amount',
            [
                'label' => __('Scale Amount', 'ultra-container'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1.05,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container.ultra-scale:hover' => 'transform: scale({{SIZE}});',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'hover_animation_type' => 'scale',
                ],
            ]
        );

        $this->add_control(
            'rotate_amount',
            [
                'label' => __('Rotate Amount', 'ultra-container'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'deg' => [
                        'min' => -180,
                        'max' => 180,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container.ultra-rotate:hover' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'hover_animation_type' => 'rotate',
                ],
            ]
        );

        $this->add_control(
            'slide_direction',
            [
                'label' => __('Slide Direction', 'ultra-container'),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __('Left', 'ultra-container'),
                    'right' => __('Right', 'ultra-container'),
                    'up' => __('Up', 'ultra-container'),
                    'down' => __('Down', 'ultra-container'),
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'hover_animation_type' => 'slide',
                ],
            ]
        );

        $this->add_control(
            'slide_distance',
            [
                'label' => __('Slide Distance', 'ultra-container'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'hover_animation_type' => 'slide',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Hover Shadow
        $this->start_controls_section(
            'hover_shadow_section',
            [
                'label' => __('Hover Shadow', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enable_hover_shadow',
            [
                'label' => __('Enable Hover Shadow', 'ultra-container'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ultra-container'),
                'label_off' => __('No', 'ultra-container'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'hover_box_shadow',
                'label' => __('Hover Box Shadow', 'ultra-container'),
                'selector' => '{{WRAPPER}} .ultra-container:hover',
                'condition' => [
                    'enable_hover_effects' => 'yes',
                    'enable_hover_shadow' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Cursor
        $this->start_controls_section(
            'cursor_section',
            [
                'label' => __('Cursor', 'ultra-container'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cursor_type',
            [
                'label' => __('Cursor Type', 'ultra-container'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'ultra-container'),
                    'pointer' => __('Pointer', 'ultra-container'),
                    'help' => __('Help', 'ultra-container'),
                    'wait' => __('Wait', 'ultra-container'),
                    'crosshair' => __('Crosshair', 'ultra-container'),
                    'not-allowed' => __('Not Allowed', 'ultra-container'),
                    'grab' => __('Grab', 'ultra-container'),
                    'grabbing' => __('Grabbing', 'ultra-container'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultra-container' => 'cursor: {{VALUE}};',
                ],
                'condition' => [
                    'enable_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Get button settings
        $enable_button = $settings['enable_button'];
        $button_link = $settings['button_link'];
        $button_target = $settings['button_target'];
        
        // Get hover animation settings
        $enable_hover_effects = $settings['enable_hover_effects'];
        $hover_animation_type = $settings['hover_animation_type'];
        
        // Build container classes
        $container_classes = ['ultra-container'];
        
        if ($enable_button === 'yes') {
            $container_classes[] = 'ultra-button';
        }
        
        if ($enable_hover_effects === 'yes') {
            $container_classes[] = 'ultra-hover-enabled';
            
            if ($hover_animation_type !== 'none') {
                $container_classes[] = 'ultra-' . $hover_animation_type;
            }
        }
        
        // Handle slide direction
        if ($hover_animation_type === 'slide' && $settings['slide_direction']) {
            $container_classes[] = 'ultra-slide-' . $settings['slide_direction'];
        }
        
        // Build container attributes
        $container_attributes = [
            'class' => implode(' ', $container_classes),
        ];
        
        // Add data attributes for JavaScript
        if ($enable_hover_effects === 'yes') {
            $container_attributes['data-hover-enabled'] = 'true';
            if ($hover_animation_type !== 'none') {
                $container_attributes['data-animation-type'] = $hover_animation_type;
            }
        }
        
        // Start output
        $this->add_render_attribute('container', $container_attributes);
        
        // Determine if we need a wrapper link
        if ($enable_button === 'yes' && !empty($button_link['url'])) {
            $target = $button_target === 'yes' ? '_blank' : '_self';
            $rel = $button_target === 'yes' ? 'noopener noreferrer' : '';
            
            echo '<a href="' . esc_url($button_link['url']) . '" target="' . esc_attr($target) . '" rel="' . esc_attr($rel) . '">';
        }
        
        echo '<div ' . $this->get_render_attribute_string('container') . '>';
        echo '<div class="ultra-container-content">';
        echo wp_kses_post($settings['container_content']);
        echo '</div>';
        echo '</div>';
        
        if ($enable_button === 'yes' && !empty($button_link['url'])) {
            echo '</a>';
        }
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        ?>
        <#
        var containerClasses = ['ultra-container'];
        var enableButton = settings.enable_button;
        var enableHoverEffects = settings.enable_hover_effects;
        var hoverAnimationType = settings.hover_animation_type;
        
        if (enableButton === 'yes') {
            containerClasses.push('ultra-button');
        }
        
        if (enableHoverEffects === 'yes') {
            containerClasses.push('ultra-hover-enabled');
            
            if (hoverAnimationType !== 'none') {
                containerClasses.push('ultra-' + hoverAnimationType);
            }
        }
        
        if (hoverAnimationType === 'slide' && settings.slide_direction) {
            containerClasses.push('ultra-slide-' + settings.slide_direction);
        }
        
        var containerClass = containerClasses.join(' ');
        #>
        
        <# if (enableButton === 'yes' && settings.button_link.url) { #>
            <a href="{{{ settings.button_link.url }}}" 
               target="{{{ settings.button_target === 'yes' ? '_blank' : '_self' }}}" 
               rel="{{{ settings.button_target === 'yes' ? 'noopener noreferrer' : '' }}}">
        <# } #>
        
        <div class="{{{ containerClass }}}" 
             data-hover-enabled="{{{ enableHoverEffects === 'yes' ? 'true' : 'false' }}}"
             data-animation-type="{{{ hoverAnimationType !== 'none' ? hoverAnimationType : '' }}}">
            <div class="ultra-container-content">
                {{{ settings.container_content }}}
            </div>
        </div>
        
        <# if (enableButton === 'yes' && settings.button_link.url) { #>
            </a>
        <# } #>
        <?php
    }
}
