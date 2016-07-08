<?php

namespace App\Models\Survey\Format\InputFormat;

class KOR_Format extends \App\Models\Survey\Format\InputFormat\Base_Format {

    protected $_inputFile;
    private $_data = [];
    private $_dataFormat;

    public function __construct($inputFileString, $outputFormat) {
        parent::__construct($inputFileString, $outputFormat);

        $this->inputFile = explode(PHP_EOL, $inputFileString);

        $this->_dataFormat = new \App\Models\Survey\Data\Convert\KOR_Format();
    }

    public function convert() {
        $fileSize = count($this->inputFile);
        for ($i = 3; $i < $fileSize - 1; $i++) {
            $this->inputFile[$i] = preg_replace("/\s\s+/", ' ', trim($this->inputFile[$i]));
            $lineSize = count(explode(' ', $this->inputFile[$i]));
            switch ($lineSize) {
                case 10:
                    list($pointName, $pointClass, $x, $y, $levelClass, $height, $mx, $my, $ms, $mh) = sscanf($this->inputFile[$i], '%s %d %f %f %d %f %f %f %f %f');
                    $this->_data[] = array(
                        'point_name' => $pointName,
                        'point_class' => $pointClass,
                        'x' => $x,
                        'y' => $y,
                        'level_class' => $levelClass,
                        'height' => $height,
                        'mx' => $mx,
                        'my' => $my,
                        'ms' => $ms,
                        'mh' => $mh
                    );
                    break;
            }
        }
    }

    public function toArray() {
        return $this->_data;
    }

    public function toString() {
        $outputFileString = $this->getData($this->_data, $this->_dataFormat, $this->оutputFormat);

        return $outputFileString;
    }

}