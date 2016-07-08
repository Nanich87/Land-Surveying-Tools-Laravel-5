<?php

namespace App\Contracts;

interface CartesianTransformation {

    public function transformPoints();

    public function getRootMeanSquareErrors();
}