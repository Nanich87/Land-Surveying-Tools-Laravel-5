<?php

namespace App\Patterns\Factory;

class InputFormatFactory {

    private function __construct() {
        
    }

    public static function create($data, $dataFormat, $outputFormat = null) {
        switch ($dataFormat) {
            case 'DINI': return new \App\Models\Survey\Format\InputFormat\DINI_Format($data, $outputFormat);
            case 'DPI': return new \App\Models\Survey\Format\InputFormat\DPI_Format($data, $outputFormat);
            case 'CAD': return new \App\Models\Survey\Format\InputFormat\CAD($data, $outputFormat);
            case 'KOR': return new \App\Models\Survey\Format\InputFormat\KOR_Format($data, $outputFormat);
            case 'KPT': return new \App\Models\Survey\Format\InputFormat\KPT_Format($data, $outputFormat);
            case 'CSV': return new \App\Models\Survey\Format\InputFormat\CSV_Format($data, $outputFormat);
            default: throw new \Exception('Invalid input format!');
        }
    }

}