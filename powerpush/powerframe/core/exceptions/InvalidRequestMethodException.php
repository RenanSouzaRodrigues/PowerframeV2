<?php

namespace powerpush\powerframe\core\exceptions;

class InvalidRequestMethodException extends \Exception {
    private $responseStatus;

    public function __construct($message, $statusCode = 400) {
        parent::__construct($message);
        $this->responseStatus = $statusCode;
    }

    public function getResponseStatus() {
        return $this->responseStatus;
    }
}

?>