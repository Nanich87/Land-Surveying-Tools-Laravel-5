<?php

namespace App\Libraries;

class CurlHelper {

    public static function executePostRequest($url, $post, $postFields) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);     
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, $post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;
    }

}
