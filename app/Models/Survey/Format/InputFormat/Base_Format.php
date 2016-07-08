<?php

namespace App\Models\Survey\Format\InputFormat;

abstract class Base_Format {

    const DEFAULT_OUTPUT_FORMAT = 'XML';

    protected $inputFile = null;
    protected $оutputFormat = null;
    private static $_supportedInputFormats = array(
        array('id' => 'DINI', 'type' => 'DINI'),
        array('id' => 'DPI', 'type' => 'DPI'),
        array('id' => 'KOR', 'type' => 'KOR'),
        array('id' => 'KPT', 'type' => 'KPT'),
        array('id' => 'CSV', 'type' => 'CSV'),
    );
    private static $_supportedOutputFormats = array(
        'XML' => 'eXtensible Markup Language',
        'TXT' => 'Text File',
        'JSON' => 'JavaScript Object Notation',
        'KML' => 'Keyhole Markup Language',
        'GPX' => 'GPS Exchange Format',
    );

    public function __construct($inputFileString, $outputFormat = self::DEFAULT_OUTPUT_FORMAT) {
        if (strlen($inputFileString) == 0) {
            throw new \Exception('Input string cannot be empty!');
        }

        $this->inputFile = $inputFileString;
        $this->setOutputFormat($outputFormat);
    }

    public function setOutputFormat($outputFormat = self::DEFAULT_OUTPUT_FORMAT) {
        if (!$this->isValidOutputFormat($outputFormat)) {
            throw new \Exception('Invalid output format!');
        }

        $this->оutputFormat = $outputFormat;
    }

    private function isValidOutputFormat($format) {
        return isset(self::$_supportedOutputFormats[$format]) ? true : false;
    }

    public static function getSupportedInputFormats() {
        return self::$_supportedInputFormats;
    }

    public static function getSupportedOutputFormats() {
        return self::$_supportedOutputFormats;
    }

    protected function getData($data, $dataFormat, $outputFormat = self::DEFAULT_OUTPUT_FORMAT) {
        $outputFileString = \App\Patterns\Factory\OutputFormatFactory::create($data, $dataFormat, $outputFormat);

        return $outputFileString->getData();
    }

    abstract function toArray();

    abstract function toString();
}