<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

use RRZE\GreenOffice\Config;
use RRZE\GreenOffice\Shortcode;
use RRZE\GreenOffice\BlockEditor;

/**
 * Main class
 */
class Main
{
    /**
     * The full path and file name of the plugin file.
     * @var string
     */
    protected $pluginFile;

    /**
     * The version of the plugin.
     * @var string
     */
    protected $pluginVersion;    

    /**
     * Assign values to variables.
     * @param string $pluginFile Path and file name of the plugin file
     */
    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;
    }

    /**
     * This method is called when the class is instantiated.
     */
    public function onLoaded()
    {
        $this->setPluginVersion();

        add_action('init', [$this, 'registerAssets']);
        add_action('enqueue_block_assets', [$this, 'enqueueAssets']);

        // Initialize Shortcode and BlockEditor
        $config = new Config($this->pluginFile);
        $default_attributes = $config::getDefaultAttributes();
        $shortcode = new Shortcode($default_attributes);
        $blockeditor = new BlockEditor($default_attributes);
    }

    /**
     * Set the version of the plugin.
     * @return string The version of the plugin
     */
    protected function setPluginVersion()
    {
        $pluginData = get_file_data($this->pluginFile, ['Version' => 'Version'], false);
        $this->pluginVersion = $pluginData['Version'] ?? '1.0.0';
    }    

    /**
     * Register assets.
     */
    public function registerAssets()
    {
        // Register scripts and styles
        wp_register_script(
            'green-office-chart',
            plugins_url('src/js/chart.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'src/js/chart.js') ?: $this->pluginVersion,
            true
        );

        wp_register_script(
            'green-office-chart-custom',
            plugins_url('src/js/chart-custom.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'src/js/chart-custom.js') ?: $this->pluginVersion,
            true
        );

        $chart_translations = array(
            'on_foot' => __('On foot', 'rrze-green-office'),
            'bicycle' => __('Bicycle', 'rrze-green-office'),
            'public_transport' => __('Public Transport', 'rrze-green-office'),
            'car' => __('Car', 'rrze-green-office'),
            'Car' => __('Car', 'rrze-green-office'),
            'co2_emission' => __('CO₂ Emission', 'rrze-green-office'),
            'usage' => __('Usage (%)', 'rrze-green-office'),
            'share' => __('Share [%]', 'rrze-green-office'),
            'annual_co2_emission' => __('Your annual CO₂ emission is:', 'rrze-green-office'),
            'could_save_you' => __('could save you', 'rrze-green-office'),
            'annual_co2_emissions' => __('Your annual CO₂ emissions are:', 'rrze-green-office'),
            'brief_analysis' => __('Brief Analysis:', 'rrze-green-office'),
            'uses' => __('uses', 'rrze-green-office'),
            'in_distance_category' => __('in their distance category.', 'rrze-green-office'),
            'has_lowest_co2_with' => __('has the lowest CO₂ emissions with', 'rrze-green-office'),
            'kg_per_year' => __('kg per year.', 'rrze-green-office'),
            'kg_CO2_per_year' => __('kg CO₂ per year.', 'rrze-green-office'),
            'kg_CO2_per_year_could_be_saved' => __('kg CO₂ per year could be saved.', 'rrze-green-office'),
            'more_co2_per_year' => __('would cause you to emit kg CO₂ more per year.', 'rrze-green-office'),
            'valid_distance' => __('Please enter valid values ​​for distance and frequency.', 'rrze-green-office'),
            'most_used_transport' => __('is the most used mode of transport.', 'rrze-green-office'),
            'assumptions' => __('Assumptions:', 'rrze-green-office'),
            'usage_percent' => __('Usage (%)', 'rrze-green-office'),
            'modal_split_selected_distance' => __('Modal Split of the selected distance', 'rrze-green-office'),
            'share_percentage' => __('Share [%]', 'rrze-green-office'),
            'your_current_co2_emission' => __('Your current CO₂ emission', 'rrze-green-office'),
            'current_co2_emission' => __('Your current CO₂ emission', 'rrze-green-office'),
            'your_co2_emission' => __('Your CO₂ emission', 'rrze-green-office'),
            'co2_equivalents' => __('CO₂ equivalents [kg/year]', 'rrze-green-office'),
            'average_weeks' => __('Due to lecture-free time or holidays and public holidays, we calculate an average of 43.5 weeks per year in which you travel to FAU.', 'rrze-green-office')
        );

        wp_localize_script('mobility-study-chart', 'chartTranslations', $chart_translations);

        wp_register_style(
            'green-office-frontend-style',
            plugins_url('build/frontend.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/frontend.css') ?: $this->pluginVersion
        );

        wp_register_script(
            'green-office-block-editor-script',
            plugins_url('build/block.js', plugin_basename($this->pluginFile)),
            ['wp-blocks', 'wp-element', 'wp-editor'],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/block.js') ?: $this->pluginVersion,
            true
        );

        wp_register_style(
            'green-office-block-editor-style',
            plugins_url('build/editor.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/editor.css') ?: $this->pluginVersion
        );
    }

    /**
     * Enqueue assets.
     */
    public function enqueueAssets()
    {
        // Enqueue registered assets for block editor and frontend
        wp_enqueue_script('green-office-random-bark');
        wp_enqueue_style('green-office-frontend-style');
    }
}
