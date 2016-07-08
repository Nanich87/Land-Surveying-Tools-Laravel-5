<?php

namespace App\Models;

use App\Contracts\CartesianTransformation as Transformation;

class AffineTransformation extends CartesianTransformation implements Transformation {

    const MIN_CONTROL_POINTS = 3;

    public function __construct($filepath) {
        if (\File::exists($filepath) === false) {
            throw new \Exception('File not found!');
        }

        $this->readXmlFile($filepath);
    }

    public function transformPoints() {
        $output = [];

        $controlPointsCount = count($this->controlPointIndices);

        if ($controlPointsCount < AffineTransformation::MIN_CONTROL_POINTS) {
            $exceptionMessage = sprint('%d or more control points are required for calculation of transformation parameters', AffineTransformation::MIN_CONTROL_POINTS);

            throw new \Exception($exceptionMessage);
        }

        $r1 = ($this->sumArrayByColumn($this->sourcePoints, 'x', $controlPointsCount) / $controlPointsCount);
        $r2 = ($this->sumArrayByColumn($this->sourcePoints, 'y', $controlPointsCount) / $controlPointsCount);
        $r3 = ($this->sumArrayByColumn($this->targetPoints, 'x', $controlPointsCount) / $controlPointsCount);
        $r4 = ($this->sumArrayByColumn($this->targetPoints, 'y', $controlPointsCount) / $controlPointsCount);

        $p1 = null;
        $p2 = null;
        $p3 = null;
        $p4 = null;
        $p5 = null;
        $p6 = null;
        $p7 = null;
        foreach ($this->controlPointIndices as $pointIndex) {
            $k1 = $this->sourcePoints[$pointIndex]['x'] - $r1;
            $k2 = $this->sourcePoints[$pointIndex]['y'] - $r2;
            $k3 = $this->targetPoints[$pointIndex]['x'] - $r3;
            $k4 = $this->targetPoints[$pointIndex]['y'] - $r4;

            $p1 += $k1 * $k1;
            $p2 += $k2 * $k2;
            $p3 += $k1 * $k3;
            $p4 += $k1 * $k4;
            $p5 += $k2 * $k3;
            $p6 += $k2 * $k4;
            $p7 += $k1 * $k2;
        }

        $q1 = $p2 * $p3 - $p7 * $p5;
        $q2 = $p1 * $p5 - $p7 * $p3;
        $q3 = $p2 * $p4 - $p7 * $p6;
        $q4 = $p1 * $p6 - $p7 * $p4;
        $q5 = $p1 * $p2 - $p7 * $p7;

        $a1 = $q1 / $q5;
        $a2 = $q2 / $q5;
        $b1 = $q3 / $q5;
        $b2 = $q4 / $q5;
        $a0 = $r3 - $a1 * $r1 - $a2 * $r2;
        $b0 = $r4 - $b1 * $r1 - $b2 * $r2;

        $residualXSquaredSum = null;
        $residualYSquaredSum = null;
        foreach (array_keys($this->sourcePoints) as $pointIndex) {
            if (!isset($this->targetPoints[$pointIndex])) {
                $output[$pointIndex]['sourceCoordinateSystem']['x'] = $this->sourcePoints[$pointIndex]['x'];
                $output[$pointIndex]['sourceCoordinateSystem']['y'] = $this->sourcePoints[$pointIndex]['y'];
                $output[$pointIndex]['targetCoordinateSystem']['x'] = $a0 + $a1 * $this->sourcePoints[$pointIndex]['x'] + $a2 * $this->sourcePoints[$pointIndex]['y'];
                $output[$pointIndex]['targetCoordinateSystem']['y'] = $b0 + $b1 * $this->sourcePoints[$pointIndex]['x'] + $b2 * $this->sourcePoints[$pointIndex]['y'];
            } else {
                $x = $a0 + $a1 * $this->sourcePoints[$pointIndex]['x'] + $a2 * $this->sourcePoints[$pointIndex]['y'];
                $y = $b0 + $b1 * $this->sourcePoints[$pointIndex]['x'] + $b2 * $this->sourcePoints[$pointIndex]['y'];

                $output[$pointIndex]['sourceCoordinateSystem']['x'] = $this->sourcePoints[$pointIndex]['x'];
                $output[$pointIndex]['sourceCoordinateSystem']['y'] = $this->sourcePoints[$pointIndex]['y'];
                $output[$pointIndex]['targetCoordinateSystem']['x'] = $this->targetPoints[$pointIndex]['x'];
                $output[$pointIndex]['targetCoordinateSystem']['y'] = $this->targetPoints[$pointIndex]['y'];
                $output[$pointIndex]['residuals']['x'] = $this->targetPoints[$pointIndex]['x'] - $x;
                $output[$pointIndex]['residuals']['y'] = $this->targetPoints[$pointIndex]['y'] - $y;

                $residualXSquaredSum += pow($output[$pointIndex]['residuals']['x'], 2);
                $residualYSquaredSum += pow($output[$pointIndex]['residuals']['y'], 2);
            }
        }

        $this->rootMeanSquareErrorX = sqrt(($residualXSquaredSum + $residualYSquaredSum) / (2 * $controlPointsCount + 6));
        $this->rootMeanSquareErrorY = sqrt(($residualXSquaredSum + $residualYSquaredSum) / (2 * $controlPointsCount + 6));
        $this->rootMeanSquareErrorTotal = $this->rootMeanSquareErrorX * sqrt(2);

        return $output;
    }

    public function getRootMeanSquareErrors() {
        $output = [];

        $output['x'] = $this->rootMeanSquareErrorX;
        $output['y'] = $this->rootMeanSquareErrorY;
        $output['total'] = $this->rootMeanSquareErrorTotal;

        return $output;
    }

}