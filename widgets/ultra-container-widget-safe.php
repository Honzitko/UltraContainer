<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Ultra Container Widget - Safe Version
 */
class Ultra_Container_Widget_Safe extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'ultra-container-safe';
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
        return ['ultra-container-safe'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['ultra-container-safe'];
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

        // Style Tab - Hover Effects (Simplified)
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
            'hover_background_color',
            [
                'label' => __('Hover Background Color', 'ultra-container'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ultra-container:hover' => 'background-color: {{VALUE}};',
                ],
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
        
        // Build container classes
        $container_classes = ['ultra-container'];
        
        if ($enable_button === 'yes') {
            $container_classes[] = 'ultra-button';
        }
        
        if ($settings['enable_hover_effects'] === 'yes') {
            $container_classes[] = 'ultra-hover-enabled';
        }
        
        // Build container attributes
        $container_attributes = [
            'class' => implode(' ', $container_classes),
        ];
        
        $this->add_render_attribute('container', $container_attributes);
        
        // Determine if we need a wrapper link
        if ($enable_button === 'yes' && !empty($button_link['url'])) {
            $target = !empty($button_link['is_external']) ? '_blank' : '_self';
            $rel = !empty($button_link['nofollow']) ? 'nofollow noopener noreferrer' : '';
            
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
        
        if (enableButton === 'yes') {
            containerClasses.push('ultra-button');
        }
        
        if (enableHoverEffects === 'yes') {
            containerClasses.push('ultra-hover-enabled');
        }
        
        var containerClass = containerClasses.join(' ');
        #>
        
        <# if (enableButton === 'yes' && settings.button_link.url) { #>
            <a href="{{{ settings.button_link.url }}}" 
               target="{{{ settings.button_link.is_external ? '_blank' : '_self' }}}" 
               rel="{{{ settings.button_link.nofollow ? 'nofollow noopener noreferrer' : '' }}}">
        <# } #>
        
        <div class="{{{ containerClass }}}">
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
