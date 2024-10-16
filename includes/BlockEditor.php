<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

class BlockEditor
{
    protected $defaultAttributes;

    public function __construct($defaultAttributes)
    {
        $this->defaultAttributes = $defaultAttributes;
        add_action('init', [$this, 'registerBlock']);
        add_action('enqueue_block_assets', [$this, 'enqueueBlockAssets']);
    }

    public function registerBlock()
    {
        register_block_type('greenoffice/quote-block', [
            'editor_script' => 'greenoffice-block-editor-script',
            'editor_style' => 'greenoffice-block-editor-style',
            'style' => 'greenoffice-block-style',
            'render_callback' => [$this, 'renderBlock']
        ]);
    }

    public function enqueueBlockAssets()
    {
        if (!is_admin()) {
            wp_enqueue_style('greenoffice-block-style');
        }
    }

    public function renderBlock($attributes)
    {
        // Sanitize attributes
        $attributes['css_classes'] = !empty($attributes['cssClasses']) ? sanitize_hex_color($attributes['cssClasses']) : '';
        $attributes['background_color'] = !empty($attributes['backgroundColor']) ? sanitize_hex_color($attributes['backgroundColor']) : '';
        $attributes['border_color'] = !empty($attributes['borderColor']) ? sanitize_hex_color($attributes['borderColor']) : '';

        wp_enqueue_script('green-office-chart');
        wp_enqueue_script('green-office-chart-custom');

        return Shortcode::generateShortcodeOutput($attributes);
    }
}
