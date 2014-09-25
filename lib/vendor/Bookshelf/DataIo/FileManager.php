<?php

namespace Bookshelf\DataIo;

class FileManager {
    
    function hash($file_path) {
        $file_text = file_get_contents($file_path, false, NULL, -1, 1048576); // Read only 1 MB
        return hash('sha256', $file_text);
    }
}