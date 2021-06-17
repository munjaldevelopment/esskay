<?php

namespace RezaAr\Highcharts\Classes\Presenters;

class InitJsPresenter
{
    public $generate;
    public $highchart;
    public $seriesLabel;
    public $exporting;
    public $exportData;
    public $init = true;

    public function __construct()
    {
        $this->generate = null;
    }

    public function init_js()
    {
        $init = '';

        if ($this->highchart == true) {
            $this->highchart = '<script src="public/assets/js/highcharts.js"></script>';
        }

        if ($this->seriesLabel == true) {
            $this->seriesLabel = '<script src="public/assets/js/series-label.js"></script>';
        }

        if ($this->exporting == true) {
            $this->exporting = '<script src="public/assets/js/exporting.js"></script>';
        }

        if ($this->exportData == true) {
            $this->exportData = '<script src="public/assets/js/export-data.js"></script>';
        }

        if ($this->init !== false) {
            $init = $this->highchart.
                $this->seriesLabel.
                $this->exporting.
                $this->exportData;
        }

        return $init;
    }

    public function generate()
    {
        $generate = $this->init_js();
        $this->generate = null;

        return $generate;
    }
}
