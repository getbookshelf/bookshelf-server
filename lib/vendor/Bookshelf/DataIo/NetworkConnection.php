<?php

namespace Bookshelf\DataIo;

class NetworkConnection {
    public static function curlRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $answer = curl_exec($ch);
        curl_close($ch);

        return $answer;
    }
}