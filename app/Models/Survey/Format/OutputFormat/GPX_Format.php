<?php

namespace App\Models\Survey\Format\OutputFormat;

class GPX_Format extends \App\Models\Survey\Format\OutputFormat\Base_Format {

    protected $format = 'GPX';

    public function __construct($data, \App\Contracts\ConvertibleFormat $format) {
        parent::__construct($data, $format);
    }

}