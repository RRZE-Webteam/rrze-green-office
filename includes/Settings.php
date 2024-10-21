<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

class Settings {

    /**
     * @var array|false|mixed|null
     */
    private mixed $options;
    private mixed $labels;

    public function __construct() {
        add_action( 'admin_init', [$this, 'registerSettings'] );
        add_action( 'admin_menu', [$this, 'addOptionsPage'] );

        $this->options = self::getOption('rrze-green-office');
        $this->labels = Config::getLabels();

    }

    public static function getOption($option) {
        $options = get_option($option);
        if (!$options) {
            $options = Config::getDefaultSettings();
        }
        return $options;
    }

    /**
     * @internal never define functions inside callbacks.
     * these functions could be run multiple times; this would result in a
     *     fatal error.
     */

    /**
     * custom option and settings
     */
    public function registerSettings() {
        // Register a new setting for "rrze-green-office" page.
        register_setting( 'rrze-green-office', 'rrze-green-office' );

        // Register a new section in the "rrze-green-office" page.
        add_settings_section(
            'transport-data',
            __( 'Transport Data', 'rrze-green-office' ), 
            [$this, 'renderSectionTransportData'],
            'rrze-green-office'
        );

        // Register a new field in the "transport-data" section, inside the "rrze-green-office" page.
        add_settings_field(
            'transport-data', // As of WP 4.6 this value is used only internally.
            // Use $args' label_for to populate the id inside the callback.
            __( 'Transport Data', 'rrze-green-office' ),
            [$this, 'renderFieldTransportData'],
            'rrze-green-office',
            'transport-data',
        );
        add_settings_field(
            'people-count',
            __('Total People', 'rrze-green-office'),
            [$this, 'renderFieldPeopleCount'],
            'rrze-green-office',
            'transport-data',
        );
        add_settings_field(
            'co2-emission-rates',
            __('CO2 Emission Rates', 'rrze-green-office'),
            [$this, 'co2EmissionRates'],
            'rrze-green-office',
            'transport-data',
        );
        add_settings_field(
            'weeks-per-year',
            __('Working Weeks per Year', 'rrze-green-office'),
            [$this, 'weeksPerYear'],
            'rrze-green-office',
            'transport-data',
        );
    }

    /**
     * Developers section callback function.
     *
     * @param array $args  The settings array, defining title, id, callback.
     */
    public function renderSectionTransportData( $args ) {
        ?>
        <!--<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'rrze-green-office' ); ?></p>-->
        <?php
    }

    public function renderFieldTransportData( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $transportData = $this->options['transport-data'] ?? false;
        if (!$transportData) return;

        $output = '';
        foreach (['students', 'employees'] as $category) {
            $output .= '<p style="font-weight:bold;">' . $this->labels[$category] . '</p>';
            $output .= '<table class="wp-list-table widefat fixed striped table-view-list">';
            foreach ($transportData as $categories) {
                $output .= '<tr><th></th>';
                foreach ($categories as $cat => $data) {
                    if ($cat != $category) {
                        continue;
                    }
                    foreach ($data as $transportMode => $value) {
                        $output .= '<th scope="col">' . $this->labels[$transportMode] . '</th>';
                    }
                    break 2;
                }
                $output .= '</tr>';
            }
            foreach ($transportData as $i => $categories) {
                $output .= '<tr>';
                $output .= '<th scope="row">' . $this->labels['transport-data'][$i] . '</th>';
                foreach ($categories as $cat => $data) {
                    if ($cat == $category)
                        continue;
                    foreach ($data as $transportMode => $value) {
                        $output .= '<td>'
                            . '<label class="sr-only screen-reader-text">' . $this->labels[$category] . ' ' . $this->labels[$transportMode] . '</label>'
                            . '<input name="rrze-green-office[transport-data][' . $i . '][' . $cat . '][' . $transportMode . ']" type="number" step="0.001" value="' . $value . '">'
                            . '</td>';
                    }
                }
                $output .= '</tr>';
            }
            $output .= '</table>';
        }

        echo wp_kses_post($output);
    }

    public function renderFieldPeopleCount($args) {
        $peopleCount = $this->options['people-count'] ?? false;
        if (!$peopleCount) return;
        $output = '';
        foreach ($peopleCount as $cat => $value) {
            $output .= '<p><label for="rrze-green-office_people-count_' . $cat .  '">'
                . $this->labels[$cat]
                . '</label>'
                . '<input type="number" step="1" min="0" name="rrze-green-office[people-count][' . $cat .  ']" id="rrze-green-office_people-count_' . $cat .  '" value="' . $value . '">'
                . '</p>';
        }
        echo wp_kses_post($output);
    }

    public function co2EmissionRates($args) {
        $co2EmissionRates = $this->options['co2-emission-rates'] ?? false;
        if (!$co2EmissionRates) return;

        foreach ($co2EmissionRates as $cat => $value) {
            $output .= '<p><label for="rrze-green-office_co2-emission-rates_' . $cat .  '" >'
                . $this->labels[$cat]
                . '</label>'
                . '<input type="number" step="1" min="0" name="rrze-green-office[co2-emission-rates][' . $cat .  ']" id="rrze-green-office_co2-emission-rates_' . $cat .  '" value="' . $value . '">'
                . '</p>';
        }
        echo wp_kses_post($output);
    }

    public function weeksPerYear($args) {
        $weeksPerYear = $this->options['weeks-per-year'] ?? false;
        if (!$weeksPerYear) return;

        echo wp_kses_post('<p><label for="rrze-green-office_weeks-per-year" >'
            . esc_html__('Working Weeks per Year', 'rrze-green-office')
            . '</label>'
            . '<input type="number" step="0.1" min="0" name="rrze-green-office[weeks-per-year]" id="rrze-green-office_weeks-per-year" value="' . $weeksPerYear . '">'
            . '</p>');
    }

    /**
     * Add the top level menu page.
     */
    public function addOptionsPage() {
        add_options_page(
            'RRZE Green Office',
            'RRZE Green Office',
            'manage_options',
            'rrze-green-office',
            [$this, 'renderOptionsPage']
        );
    }

    /**
     * Top level menu callback function
     */
    public function renderOptionsPage() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // show error/update messages
        settings_errors( 'rrze-green-office_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "rrze-green-office"
                settings_fields( 'rrze-green-office' );
                // output setting sections and their fields
                // (sections are registered for "rrze-green-office", each field is registered to a specific section)
                do_settings_sections( 'rrze-green-office' );
                // output save settings button
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

}