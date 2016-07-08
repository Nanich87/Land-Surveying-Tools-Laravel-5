<?php

namespace App\Models;

abstract class CartesianTransformation {

    const SHEMA_LOCATION = 'schemas/CartesianTransformation.xsd';

    protected $sourcePoints = [];
    protected $targetPoints = [];
    protected $controlPointIndices = [];
    protected $rootMeanSquareErrorX = 0;
    protected $rootMeanSquareErrorY = 0;
    protected $rootMeanSquareErrorTotal = 0;

    protected function readXmlFile($filepath) {
        $document = new \DOMDocument();
        $document->preserveWhiteSpace = false;
        
        if (@$document->load($filepath)) {
            //libxml_use_internal_errors(true);

            if ($document->schemaValidate(CartesianTransformation::SHEMA_LOCATION)) {
                $points = simplexml_load_file($filepath);
                $this->parsePoints($points);
            } else {
                throw new \Exception('Невалиден XML документ!');
            }

            //libxml_use_internal_errors(false);
        } else {
            throw new \Exception('Невалиден XML файл!');
        }
    }

    private function parsePoints($points) {
        foreach ($points as $pointType => $pointData) {
            $this->parseSinglePoint($pointType, $pointData);
        }
    }

    private function parseSinglePoint($type, $data) {
        switch ($type) {
            case 'commonPoint':
                $id = $data->id->__toString();
                $this->sourcePoints[$id]['x'] = floatval($data->inputCoordinateSystem->x);
                $this->sourcePoints[$id]['y'] = floatval($data->inputCoordinateSystem->y);
                $this->targetPoints[$id]['x'] = floatval($data->outputCoordinateSystem->x);
                $this->targetPoints[$id]['y'] = floatval($data->outputCoordinateSystem->y);
                $this->controlPointIndices[] = $id;
                break;
            case 'inputPoint':
                $id = $data->id->__toString();
                $this->sourcePoints[$id]['x'] = floatval($data->inputCoordinateSystem->x);
                $this->sourcePoints[$id]['y'] = floatval($data->inputCoordinateSystem->y);
                break;
        }
    }

    protected function sumArrayByColumn($array, $column, $limit) {
        $sum = 0;
        $rowIndex = 0;

        foreach ($array as $value) {
            $sum += $value[$column];
            $rowIndex += 1;
            if ($rowIndex == $limit) {
                break;
            }
        }

        return $sum;
    }

}