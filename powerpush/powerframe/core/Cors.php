<?php

namespace powerpush\powerframe\core;

class Cors {
    public function all() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");
    }

    public function origins($hosts) {
        header("Access-Control-Allow-Origin: " . $hosts);
    }

    public function methods($methods) {
        header("Access-Control-Allow-Methods: " . $methods);
    }

    public function headers($headers) {
        header("Access-Control-Allow-Methods: " . $headers);
    }
}

?>