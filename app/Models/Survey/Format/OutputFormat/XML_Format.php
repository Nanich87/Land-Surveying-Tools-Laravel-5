<?php

namespace App\Models\Survey\Format\OutputFormat;

class XML_Format extends \App\Models\Survey\Format\OutputFormat\Base_Format {

    protected $format = 'XML';

    public function __construct($data, \App\Contracts\ConvertibleFormat $format) {
        parent::__construct($data, $format);
    }

}