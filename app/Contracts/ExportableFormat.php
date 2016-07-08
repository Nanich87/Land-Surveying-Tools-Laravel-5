<?php

namespace App\Contracts;

interface ExportableFormat {

    public function setData($data);

    public function setFormat(\Contracts\ConvertibleFormat $format);

    public function getData();
}