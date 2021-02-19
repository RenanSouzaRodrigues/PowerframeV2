<?php 

namespace controllers;

class TestController {
    public function sendTestMessage($res) {
        $res->status(200)->json(['message' => 'TestController is working fine']);
    }

    public function testParameters($req, $res) {
        $res->status(200)->json($req->params);
    }

    public function testBody($req, $res) {
        $res->status(200)->json($req->body);
    }
}

?>