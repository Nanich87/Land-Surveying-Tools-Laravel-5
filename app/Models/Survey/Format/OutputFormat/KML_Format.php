<?php

namespace App\Models\Survey\Format\OutputFormat;

class KML_Format extends \App\Models\Survey\Format\OutputFormat\Base_Format {

    protected $format = 'KML';

    public function __construct($data, \App\Contracts\ConvertibleFormat $format) {
        parent::__construct($data, $format);
    }

}