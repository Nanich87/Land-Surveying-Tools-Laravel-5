<?php

namespace App\Patterns\Factory;

class CartesianTransformationFactory {

    private function __construct() {
        
    }

    public static function create($transformationType, $inputData) {
        switch ($transformationType) {
            case 'Affine': return new \App\Models\AffineTransformation($inputData);
            case 'Helmert': return new \App\Models\AffineTransformation($inputData);
            default: throw new \Exception('Invalid Cartesian Transformation type!');
        }
    }

}