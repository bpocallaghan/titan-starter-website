<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait ReportChartTable
{
    // http://www.colorhexa.com
    protected $datasets = [
        [ // BLUE
            'label'                => "",
            'fillColor'            => "rgba(60, 141, 188, 0.1)",
            'strokeColor'          => "rgba(60, 141, 188, 1)",
            'pointColor'           => "#3b8bba",
            'pointStrokeColor'     => "rgba(60,141,188,1)",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
        [ // GREEN
            'label'                => "",
            'fillColor'            => "rgba(0, 141, 76, 0.1)",
            'strokeColor'          => "rgba(0, 141, 76, 1)",
            'pointColor'           => "rgba(0, 141, 76, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
        [ // BRONZE - BROWN
            'label'                => "",
            'fillColor'            => "rgba(185, 114, 45, 0.1)",
            'strokeColor'          => "rgba(185, 114, 45, 1)",
            'pointColor'           => "rgba(185, 114, 45, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
        [ // SILVER - GREY
            'label'                => "",
            'fillColor'            => "rgba(192, 192, 192, 0.1)",
            'strokeColor'          => "rgba(192, 192, 192, 1)",
            'pointColor'           => "rgba(192, 192, 192, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
        [ // GOLD - YELLOW
            'label'                => "",
            'fillColor'            => "rgba(255, 200, 0, 0.1)",
            'strokeColor'          => "rgba(255, 200, 0, 1)",
            'pointColor'           => "rgba(255, 200, 0, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
    ];

    protected $colorsPlaceholders = [
        'rgba(22, 160, 133, 1)',
        'rgba(52, 152, 219, 1)',
        'rgba(142, 68, 173, 1)',
        'rgba(243, 156, 18, 1)',
        'rgba(231, 76, 60, 1)',
        'rgba(192, 57, 43, 1)',
        'rgba(230, 126, 34, 1)',
        'rgba(241, 196, 15, 1)',
        'rgba(46, 204, 113, 1)',
        'rgba(127, 140, 141, 1)',
        'rgba(189, 195, 199, 1)',
        'rgba(149, 165, 166, 1)',
        'rgba(52, 73, 94, 1)',
        'rgba(44, 62, 80, 1)',
        'rgba(155, 89, 182, 1)',
        'rgba(41, 128, 185, 1)',
        'rgba(26, 188, 156, 1)',
        'rgba(39, 174, 96, 1)',
    ];

    private function inputDateFrom()
    {
        return input('date_from', Carbon::now()->subWeeks(4)->format('Y-m-d'));
    }

    private function inputDateTo()
    {
        return input('date_to', Carbon::now()->format('Y-m-d'));
    }

    /**
     * Get the line dataset opbject
     * @param     $label
     * @param     $data
     * @param int $index
     * @return mixed
     */
    private function getDataSet($label, $data, $index = 0)
    {
        $set = $this->datasets[$index];
        $set['label'] = $label;
        $set['data'] = $data;

        $backgrounds = [];
        $borderColor = [];

        if(!array_key_exists($index,$this->colorsPlaceholders)){

            $tmp = $this->colorsPlaceholders;
            $this->colorsPlaceholders = array_merge($this->colorsPlaceholders, $tmp);
        }

        $backgrounds [] = str_replace(", 1)", ", 0.2)", $this->colorsPlaceholders[$index]);
        $borderColor [] = $this->colorsPlaceholders[$index];


        $set['backgroundColor'] = $backgrounds;
        $set['borderColor'] = $borderColor;
        $set['pointBorderColor'] = '#fff';
        $set['pointBackgroundColor'] = $borderColor[0];
        $set['borderWidth'] = 1.5;

        return $set;

        //$set = $this->datasets[$index];
        //$set['label'] = $label;
        //$set['data'] = $data;
        //
        //return $set;
    }
}