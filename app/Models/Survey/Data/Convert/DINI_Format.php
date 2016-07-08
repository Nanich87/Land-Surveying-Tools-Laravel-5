<?php

namespace App\Models\Survey\Data\Convert;

class DINI_Format implements \App\Contracts\ConvertibleFormat {

    public function convert($data, $format) {
        $method = 'convertTo' . $format;
        if (!method_exists(__CLASS__, $method)) {
            throw new \Exception(sprintf("Dini format does not support conversion to %s!", $format));
        }

        return $this->$method($data);
    }

    private function convertToXML($data) {
        $outputString = '<LevelingNetwork>';
        $outputString .= '<WeightMode>1</WeightMode>';
        $outputString .= '<Lines>';

        foreach ($data as $line) {
            $outputString .= '<Line>';
            $outputString .= sprintf('<BackBenchmark>%s</BackBenchmark>', $line['back_benchmark']);
            $outputString .= sprintf('<ForwardBenchmark>%s</ForwardBenchmark>', $line['forward_benchmark']);
            $outputString .= sprintf('<Elevation>%1.4f</Elevation>', $line['elevation']);
            $outputString .= sprintf('<Length>%1.2f</Length>', $line['length']);
            $outputString .= sprintf('<Station>0</Station>');
            $outputString .= '</Line>';
        }

        $outputString .= '</Lines>';
        $outputString .= '</LevelingNetwork>';

        return $outputString;
    }

    private function convertToTXT($data) {
        $outputString = '';

        foreach ($data as $line) {
            $outputString .= sprintf("%s %s %1.4f %1.2f 0%s", $line['back_benchmark'], $line['forward_benchmark'], $line['elevation'], $line['length'], PHP_EOL);
        }

        return $outputString;
    }

    private function convertToJSON($data) {
        return json_encode($data);
    }

}