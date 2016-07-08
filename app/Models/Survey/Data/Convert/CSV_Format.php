<?php

namespace App\Models\Survey\Data\Convert;

class CSV_Format implements \App\Contracts\ConvertibleFormat {

    public function convert($data, $format) {
        $method = 'convertTo' . $format;
        if (!method_exists(__CLASS__, $method)) {
            throw new \Exception(sprintf("CSV format does not support conversion to %s!", $format));
        }

        return $this->$method($data);
    }

    private function convertToGPX($data) {
        $outputString = '<?xml version="1.0" encoding="UTF-8" standalone="no" ?>';
        $outputString .= '<gpx xmlns="http://www.topografix.com/GPX/1/1" creator="MapSource 6.13.7" version="1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensions/v3/GpxExtensionsv3.xsd http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd">';
        $outputString .= '<metadata>';
        $outputString .= ' <link href="http://www.garmin.com">';
        $outputString .= '  <text>Garmin International</text>';
        $outputString .= ' </link>';
        $outputString .= ' <bounds maxlat="0" maxlon="0" minlat="0" minlon="0" />';
        $outputString .= '</metadata>';

        foreach ($data as $line) {
            $outputString .= '<wpt lat="' . $line['lat'] . '" lon="' . $line['lon'] . '">';
            $outputString .= ' <name>' . $line['point'] . '</name>';
            $outputString .= ' <sym>Waypoint</sym>';
            $outputString .= ' <extensions>';
            $outputString .= '  <gpxx:WaypointExtension xmlns:gpxx="http://www.garmin.com/xmlschemas/GpxExtensions/v3">';
            $outputString .= '   <gpxx:DisplayMode>SymbolAndName</gpxx:DisplayMode>';
            $outputString .= '   <gpxx:Categories>';
            $outputString .= '    <gpxx:Category>My Category</gpxx:Category>';
            $outputString .= '   </gpxx:Categories>';
            $outputString .= '  </gpxx:WaypointExtension>';
            $outputString .= ' </extensions>';
            $outputString .= '</wpt>';
        }

        $outputString .= '</gpx>';

        return $outputString;
    }

}