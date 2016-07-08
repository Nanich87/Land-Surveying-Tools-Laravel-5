<?php

namespace App\Contracts;

interface ConvertibleFormat {

    public function convert($data, $format);
}