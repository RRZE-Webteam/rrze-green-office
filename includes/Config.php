<?php

namespace RRZE\GreenOffice;

defined('ABSPATH') || exit;

class Config
{
    protected $pluginFile;

    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;
    }

    public static function getDefaultAttributes() {
        return [];
    }

    public static function getDefaultSettings() {
        return [
            'transport-data' => [
                [
                    'students' => [
                        'foot' => 0.308,
                        'bike' => 0.548,
                        'opnv' => 0.137,
                        'miv' => 0.006,
                        'other' => 0.001,
                        'total' => 586,
                    ],
                    'employees' => [
                        'foot' => 0.278,
                        'bike' => 0.666,
                        'opnv' => 0.044,
                        'miv' => 0.007,
                        'other' => 0.004,
                        'total' => 250,
                    ],
                ],
                [
                    'students' => [
                        'foot' => 0.027,
                        'bike' => 0.555,
                        'opnv' => 0.383,
                        'miv' => 0.032,
                        'other' => 0.003,
                        'total' => 623,
                    ],
                    'employees' => [
                        'foot' => 0.025,
                        'bike' => 0.773,
                        'opnv' => 0.128,
                        'miv' => 0.07,
                        'other' => 0.003,
                        'total' => 302,
                    ],
                ],
                [
                    'students' => [
                        'foot' => 0.013,
                        'bike' => 0.427,
                        'opnv' => 0.488,
                        'miv' => 0.069,
                        'other' => 0.002,
                        'total' => 366,
                    ],
                    'employees' => [
                        'foot' => 0.002,
                        'bike' => 0.648,
                        'opnv' => 0.163,
                        'miv' => 0.187,
                        'other' => 0,
                        'total' => 290,
                    ],
                ],
                [
                    'students' => [
                        'foot' => 0,
                        'bike' => 0.052,
                        'opnv' => 0.764,
                        'miv' => 0.184,
                        'other' => 0,
                        'total' => 777,
                    ],
                    'employees' => [
                        'foot' => 0.003,
                        'bike' => 0.144,
                        'opnv' => 0.349,
                        'miv' => 0.502,
                        'other' => 0.002,
                        'total' => 529,
                    ],
                ],
                [
                    'students' => [
                        'foot' => 0,
                        'bike' => 0.002,
                        'opnv' => 0.71,
                        'miv' => 0.288,
                        'other' => 0,
                        'total' => 525,
                    ],
                    'employees' => [
                        'foot' => 0,
                        'bike' => 0.019,
                        'opnv' => 0.391,
                        'miv' => 0.59,
                        'other' => 0,
                        'total' => 287,
                    ],
                ],
                [
                    'students' => [
                        'foot' => 0,
                        'bike' => 0,
                        'opnv' => 0.799,
                        'miv' => 0.201,
                        'other' => 0,
                        'total' => 244,
                    ],
                    'employees' => [
                        'foot' => 0,
                        'bike' => 0,
                        'opnv' => 0.576,
                        'miv' => 0.424,
                        'other' => 0,
                        'total' => 135,
                    ],
                ],

            ],
            'people-count' => [
                'students' => 3121,
                'employees' => 1793,
            ],
            'co2-emission-rates' => [
                'foot' => 0,
                'bike' => 9,
                'opnv' => 60,
                'miv' => 169,
                'other' => 0,
            ],
            'weeks-per-year' => 43.5,
        ];
    }

    public static function getLabels() {
        return [
            'students' => __('Students', 'rrze-green-office'),
            'employees' => __('Employees', 'rrze-green-office'),
            'foot' => __('On Foot', 'rrze-green-office'),
            'bike' => __('Bike', 'rrze-green-office'),
            'opnv' => __('Public Transport', 'rrze-green-office'),
            'miv' => __('Car', 'rrze-green-office'),
            'other' => __('Other', 'rrze-green-office'),
            'total' => __('Total', 'rrze-green-office'),
            'transport-data' => [
                __('< 2.5km','rrze-green-office'),
                __('2.5 - 5km','rrze-green-office'),
                __('5 - 10km','rrze-green-office'),
                __('10 - 25km','rrze-green-office'),
                __('25 - 50km','rrze-green-office'),
                __('> 50km','rrze-green-office'),
            ],
        ];
    }
}
