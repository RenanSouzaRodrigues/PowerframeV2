<?php 

namespace powerpush\powerframe\core;

class Request {
    public $body = null;
    public $params = null;
    public $headers = null;
    public $query = null;

    public function setBody($body) {
        $this->body = $body;
    } 

    public function setParams($params) {
        $this->params = $params;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }
}

?>