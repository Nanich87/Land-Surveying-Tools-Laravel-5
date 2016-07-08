<?php

namespace App\Models\Survey\Format\OutputFormat;

class TXT_Format extends \App\Models\Survey\Format\OutputFormat\Base_Format {

    protected $format = 'TXT';

    public function __construct($data, \App\Contracts\ConvertibleFormat $format) {
        parent::__construct($data, $format);
    }

}