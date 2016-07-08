<?php

namespace App\Models\Survey\Data\Convert;

class KOR_Format implements \App\Contracts\ConvertibleFormat {

    public function convert($data, $format) {
        $method = 'convertTo' . $format;
        if (!method_exists(__CLASS__, $method)) {
            throw new \Exception(sprintf("Kor format does not support conversion to %s!", $format));
        }

        return $this->$method($data);
    }

    private function convertToXML($data) {
        $outputString = '<Network>';
        $outputString .= '<Points>';
        
        foreach ($data as $point) {
            $outputString .= '<Point>';
            $outputString .= sprintf('<Number>%s</Number>', $point['point_name']);
            $outputString .= sprintf('<HClass>%s</HClass>', $point['point_class']);
            $outputString .= sprintf('<PositionX>%1.3f</PositionX>', $point['x']);
            $outputString .= sprintf('<PositionY>%1.3f</PositionY>', $point['y']);
            $outputString .= sprintf('<VClass>%s</VClass>', $point['level_class']);
            $outputString .= sprintf('<Height>%1.3f</Height>', $point['height']);
            $outputString .= sprintf('<Mx>%1.3f</Mx>', $point['mx']);
            $outputString .= sprintf('<My>%1.3f</My>', $point['my']);
            $outputString .= sprintf('<Ms>%1.3f</Ms>', $point['ms']);
            $outputString .= sprintf('<Mh>%1.3f</Mh>', $point['mh']);
            $outputString .= '</Point>';
        }
        
        $outputString .= '</Points>';
        $outputString .= '</Network>';
        
        return $outputString;
    }

    private function convertToTXT($data) {
        $outputString = '';
        
        foreach ($data as $point) {
            $outputString .= implode(' ', $point) . PHP_EOL;
        }
        
        return $outputString;
    }

    private function convertToKML($data) {
        $outputString = '<?xml version="1.0" encoding="UTF-8"?>';
        $outputString .= '<kml xmlns="http://www.opengis.net/kml/2.2">';
        
        foreach ($data as $point) {
            $outputString .= '<Placemark>';
            $outputString .= sprintf('<name>%s</name>', $point['point_name']);
            $outputString .= sprintf('<description>%s</description>', $point['height']);
            $outputString .= sprintf('<Point><coordinates>%s,%s</coordinates></Point>', $point['x'], $point['y']);
            $outputString .= '</Placemark>';
        }
        
        $outputString .= '</kml>';
        
        return $outputString;
    }

    private function convertToJSON($data) {
        return json_encode($data);
    }

}