<?php

namespace App\Models\Survey\Format\InputFormat;

class DPI_Format extends \App\Models\Survey\Format\InputFormat\Base_Format {

    protected $_inputFile;
    
    private $_data = [];
    private $_dataFormat;

    public function __construct($inputFileString, $outputFormat) {
        parent::__construct($inputFileString, $outputFormat);
        
        $this->inputFile = explode(PHP_EOL, $inputFileString);
        
        $this->_dataFormat = new \App\Models\Survey\Data\Convert\DPI_FORMAT();
    }

    public function convert() {
        $fileSize = count($this->inputFile);
        for ($i = 3; $i < $fileSize - 1; $i++) {
            $this->inputFile[$i] = preg_replace("/\s\s+/", ' ', trim($this->inputFile[$i]));
            $lineSize = count(explode(' ', $this->inputFile[$i]));
            switch ($lineSize) {
                case 4:
                    list($backBenchmark) = sscanf($this->inputFile[$i], 'Stn %s Vi 0.000');
                    break;
                case 6:
                    list($forwardBenchmark, $length, $elevation) = sscanf($this->inputFile[$i], 'Nt %s D %f h %f');
                    $this->_data[] = array(
                        'back_benchmark' => $backBenchmark,
                        'forward_benchmark' => $forwardBenchmark,
                        'elevation' => $elevation,
                        'length' => $length
                    );
                    break;
            }
        }
    }

    public function toArray() {
        return $this->_data;
    }

    public function toString() {
        $outputString = $this->getData($this->_data, $this->_dataFormat, $this->оutputFormat);
        
        return $outputString;
    }

}