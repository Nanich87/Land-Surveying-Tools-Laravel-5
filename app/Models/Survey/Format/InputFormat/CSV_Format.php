<?php

namespace App\Models\Survey\Format\InputFormat;

class CSV_Format extends \App\Models\Survey\Format\InputFormat\Base_Format {

    protected $inputFile;
    private $_data = [];
    private $_dataFormat;

    public function __construct($inputFileString, $outputFormat) {
        parent::__construct($inputFileString, $outputFormat);

        $this->inputFile = explode(PHP_EOL, $inputFileString);

        $this->_dataFormat = new \App\Models\Survey\Data\Convert\CSV_Format();
    }

    public function convert() {
        $fileSize = count($this->inputFile);
        for ($i = 0; $i < $fileSize; $i++) {
            $rowData = explode(',', $this->inputFile[$i]);
            $columnSize = count($rowData);
            switch ($columnSize) {
                case 3:
                    $this->_data[] = array(
                        'point' => $rowData[0],
                        'lat' => $rowData[1],
                        'lon' => $rowData[2]
                    );
                    break;
                case 4:
                    $this->_data[] = array(
                        'point' => $rowData[0],
                        'lat' => $rowData[1],
                        'lon' => $rowData[2],
                        'height' => $rowData[3]
                    );
                    break;
                case 5:
                    $this->_data[] = array(
                        'point' => $rowData[0],
                        'lat' => $rowData[1],
                        'lon' => $rowData[2],
                        'height' => $rowData[3],
                        'description' => $rowData[4]
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