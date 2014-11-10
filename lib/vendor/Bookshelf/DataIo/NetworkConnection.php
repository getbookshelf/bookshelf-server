<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;

class NetworkConnection {
    public static function curlRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Bookshelf/' . Application::VERSION_TEXT . ' (gzip; +http://getbookshelf.org)');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        $answer = curl_exec($ch);
        curl_close($ch);

        return $answer;
    }
}
