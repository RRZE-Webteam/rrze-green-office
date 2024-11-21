<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

class Shortcode
{

    public function __construct()
    {
        add_shortcode('co2_emissions_calculator', [$this, 'renderShortcode']);
    }

    public static function renderShortcode()
    {
        // Enqueue assets
        wp_enqueue_style('rrze-green-office-style');
        wp_enqueue_script('green-office-chart');
        wp_enqueue_script('green-office-chart-custom');

        // Generate the output
        $output = '<div class="rrze-green-office co2-emissions-calculator">
            <div class="input-container">
                <div class="input-distance">
                    <label for="distance">' . __('My route to FAU in km:', 'rrze-green-office') . '</label>
                    <input type="number" id="distance" step="0.1" class="form-control mb-2" placeholder="' . esc_attr__('e.g., 4.5', 'rrze-green-office') . '" aria-required="true">
                </div>
                
                <div class="input-frequency">
                    <label for="frequency">' . __('Trips per week:', 'rrze-green-office') . '</label>
                    <input type="number" id="frequency" min="1" max="7" class="form-control mb-2" placeholder="' . esc_attr__('e.g., 5', 'rrze-green-office') . '" aria-required="true">
                </div>

                <div class="input-transport">
                    <label for="transport">' . __('Mode of transport:', 'rrze-green-office') . '</label>
                    <select id="transport" class="form-select mb-2" aria-required="true">
                        <option value="" disabled selected>' . __('Choose mode of transport', 'rrze-green-office') . '</option>
                        <option value="foot">' . __('On foot', 'rrze-green-office') . '</option>
                        <option value="bike">' . __('Bicycle / E-bike / E-scooter / Pedelec', 'rrze-green-office') . '</option>
                        <option value="opnv">' . __('Public Transport', 'rrze-green-office') . '</option>
                        <option value="miv">' . __('Car', 'rrze-green-office') . '</option>
                    </select>
                </div>

                <div class="input-usertype">
                    <label for="userType">' . __('I am:', 'rrze-green-office') . '</label>
                    <select id="userType" class="form-select mb-2" aria-required="true">
                        <option value="" disabled selected>' . __('Select', 'rrze-green-office') . '</option>
                        <option value="students">' . __('Student', 'rrze-green-office') . '</option>
                        <option value="employees">' . __('Employee', 'rrze-green-office') . '</option>
                    </select>
                </div>
                
                <div class="input-button">
                    <button onclick="updateChart()" class="btn btn-primary">' . __('Calculate', 'rrze-green-office') . '</button>
                </div>
            </div>

            <div class="chart-container" aria-hidden="true">
                <div class="chart-item">
                    <canvas id="co2Chart" width="400" height="200"></canvas>
                </div>
                <div class="chart-item">
                    <canvas id="modalSplitChart" width="400" height="200"></canvas>
                </div>
            </div>

            <div class="result-container">
                <div id="result"></div>
            </div>
        </div>';

        return $output;
    }
}
