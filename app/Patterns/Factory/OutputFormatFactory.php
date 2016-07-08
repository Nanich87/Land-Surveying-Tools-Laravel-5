<?php

namespace App\Patterns\Factory;

class OutputFormatFactory {

    private function __construct() {
        
    }

    public static function create($data, $dataFormat, $outputFormat) {
        switch ($outputFormat) {
            case 'XML': return new \App\Models\Survey\Format\OutputFormat\XML_Format($data, $dataFormat);
            case 'TXT': return new \App\Models\Survey\Format\OutputFormat\TXT_Format($data, $dataFormat);
            case 'JSON': return new \App\Models\Survey\Format\OutputFormat\JSON_Format($data, $dataFormat);
            case 'KML': return new \App\Models\Survey\Format\OutputFormat\KML_Format($data, $dataFormat);
            case 'GPX': return new \App\Models\Survey\Format\OutputFormat\GPX_Format($data, $dataFormat);
            default: throw new \Exception('Invalid output format!');
        }
    }

}