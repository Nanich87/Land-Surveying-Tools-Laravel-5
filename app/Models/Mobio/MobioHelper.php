<?php

namespace App\Models\Mobio;

class MobioHelper {

    public static function checkCode($servID, $code, $debug = 0) {
        $return = 0;

        $mobioSocket = fsockopen("www.mobio.bg", 80);

        if (!$mobioSocket) {
            if ($debug) {
                echo "Unable to connect to mobio.bg server\n";
            }

            $return = 0;
        } else {
            $request .= "GET http://www.mobio.bg/code/checkcode.php?servID=$servID&code=$code HTTP/1.0\r\n\r\n";

            fwrite($mobioSocket, $request);

            $result = fread($mobioSocket, 255);

            if (strstr($result, "PAYBG=OK")) {
                $return = 1;
            } else {
                $return = 0;

                if ($debug) {
                    echo strstr($result, "PAYBG");
                }
            }

            fclose($mobioSocket);
        }

        return $return;
    }

}