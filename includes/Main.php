<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

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
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueueAssets']);

        // Initialize Shortcode and BlockEditor
        $config = new Config($this->pluginFile);
        $shortcode = new Shortcode();
        $settings = new Settings();
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
            plugins_url('assets/js/chart.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/chart.js') ?: $this->pluginVersion,
            true
        );

        wp_register_script(
            'green-office-chart-custom',
            plugins_url('assets/js/chart-custom.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/chart-custom.js') ?: $this->pluginVersion,
            true
        );

        $options = Settings::getOption('rrze-green-office');
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
            /* translators: Number of weeks*/
            'average_weeks' => sprintf(__('Due to lecture-free time or holidays and public holidays, we calculate an average of %s weeks per year in which you travel to FAU.', 'rrze-green-office'), (string)number_format_i18n($options['weeks-per-year'], 1)),
        );

        wp_localize_script('green-office-chart-custom', 'chartTranslations', $chart_translations);

        $settings = Settings::getOption('rrze-green-office');
        wp_localize_script('green-office-chart-custom', 'chartData', $settings['transport-data']);
        wp_localize_script('green-office-chart-custom', 'chartPeople', $settings['people-count']);
        wp_localize_script('green-office-chart-custom', 'chartRates', $settings['co2-emission-rates']);
        wp_localize_script('green-office-chart-custom', 'weeksPerYear', [$settings['weeks-per-year']]);
    }

    /**
     * Enqueue assets.
     */
    public function enqueueAssets()
    {
        // Enqueue registered assets for block editor and frontend

    }

    public function adminEnqueueAssets() {
        wp_enqueue_style('green-office-frontend-style');
        wp_enqueue_style(
            'rrze-green-office-admin-style',
            plugins_url('assets/css/admin.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/admin.css') ?: $this->pluginVersion
        );
    }
}
